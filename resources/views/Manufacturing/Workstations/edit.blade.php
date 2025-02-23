@extends('master')

@section('title')
    تعديل محطة العمل
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
                    <h2 class="content-header-title float-left mb-0">تعديل محطة العمل</h2>
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

            <form class="form-horizontal" action="{{ route('manufacturing.workstations.update', $workstation->id) }}" method="POST">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <div>
                                <label>الحقول التي عليها علامة <span style="color: red">*</span> الزامية</label>
                            </div>

                            <div>
                                <a href="{{ route('manufacturing.workstations.index') }}" class="btn btn-outline-danger">
                                    <i class="fa fa-ban"></i> الغاء
                                </a>
                                <button type="submit" class="btn btn-outline-primary">
                                    <i class="fa fa-save"></i> تحديث
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <h4 class="card-title">معلومات محطة العمل</h4>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="">الاسم <span style="color: red">*</span></label>
                                    <input type="text" class="form-control" name="name" value="{{ old('name', $workstation->name) }}">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="">كود <span style="color: red">*</span></label>
                                    <input type="text" class="form-control" name="code" value="{{ old('code', $workstation->code) }}">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="">الوحدة</label>
                                    <input type="text" class="form-control" name="unit" value="{{ old('unit', $workstation->unit) }}">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="">الوصف</label>
                                    <textarea name="description" class="form-control" rows="2">{{ old('description', $workstation->description) }}</textarea>
                                </div>

                                <br>

                                <div class="form-group col-md-12">
                                    <p onclick="toggleSection('rawMaterials')" class="d-flex justify-content-between section-header" style="background: #DBDEE2; width: 100%;">
                                        <span class="p-1 font-weight-bold"><i class="fa fa-money"></i> المصروفات (<span id="rawMaterialCount">{{ $workstation->stationsCosts->count() }}</span>)</span>
                                        <i class="feather icon-plus-circle p-1"></i>
                                    </p>
                                    <div id="rawMaterials">
                                        <table class="table table-striped" id="itemsTable">
                                            <thead style="background: #f8f8f8">
                                                <tr>
                                                    <th>التكلفة</th>
                                                    <th>الحساب</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($workstation->stationsCosts as $expense)
                                                    <tr>
                                                        <td>
                                                            <input type="number" name="cost_expenses[]" class="form-control unit-price" value="{{ old('cost_expenses.' . $loop->index, $expense->cost_expenses) }}" oninput="calculateTotalCost()">
                                                        </td>
                                                        <td>
                                                            <select name="account_expenses[]" class="form-control select2 product-select">
                                                                <option value="" disabled>-- اختر الحساب --</option>
                                                                @foreach ($accounts as $account)
                                                                    <option value="{{ $account->id }}" {{ old('account_expenses.' . $loop->index, $expense->account_id) == $account->id ? 'selected' : '' }}>
                                                                        {{ $account->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td style="width: 10px">
                                                            <button type="button" class="btn btn-outline-danger btn-sm removeRow"><i class="fa fa-trash"></i></button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <hr>
                                        <div class="d-flex justify-content-between mt-2">
                                            <button type="button" class="btn btn-outline-success btn-sm" id="addRow"><i class="fa fa-plus"></i> إضافة</button>
                                        </div>
                                    </div>
                                </div>
                                <br><hr>

                                <div class="form-group col-md-12">
                                    <p onclick="toggleSection('expenses')" class="d-flex justify-content-between section-header" style="background: #DBDEE2; width: 100%;">
                                        <span class="p-1 font-weight-bold"><i class="fa fa-money"></i> الاجور</span>
                                        <i class="feather icon-plus-circle p-1"></i>
                                    </p>
                                    <div id="expenses" style="display: none">
                                        <table class="table table-striped" id="ExpensesTable">
                                            <thead style="background: #f8f8f8">
                                                <tr>
                                                    <th>التكلفة</th>
                                                    <th>الحساب</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <input type="number" name="cost_wages" class="form-control unit-price" value="{{ old('cost_wages', $workstation->cost_wages) }}" oninput="calculateTotalCost()">
                                                    </td>
                                                    <td>
                                                        <select name="account_wages" class="form-control select2 product-select">
                                                            <option value="" disabled>-- اختر الحساب --</option>
                                                            @foreach ($accounts as $account)
                                                                <option value="{{ $account->id }}" {{ old('account_wages', $workstation->wages_account_id) == $account->id ? 'selected' : '' }}>
                                                                    {{ $account->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <br><hr>

                                <div class="form-group col-md-12">
                                    <p onclick="toggleSection('manufacturing')" class="d-flex justify-content-between section-header" style="background: #DBDEE2; width: 100%;">
                                        <span class="p-1 font-weight-bold"><i class="feather icon-folder"></i> أصل</span>
                                        <i class="feather icon-plus-circle p-1"></i>
                                    </p>
                                    <div id="manufacturing" style="display: none">
                                        <table class="table table-striped" id="manufacturingTable">
                                            <thead style="background: #f8f8f8">
                                                <tr>
                                                    <th>التكلفة</th>
                                                    <th>أصل</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <input type="number" name="cost_origin" class="form-control unit-price" value="{{ old('cost_origin', $workstation->cost_origin) }}" oninput="calculateTotalCost()">
                                                    </td>
                                                    <td>
                                                        <select name="origin" class="form-control select2 product-select">
                                                            <option value="" disabled>-- اختر الحساب --</option>
                                                            @foreach ($accounts as $account)
                                                                <option value="{{ $account->id }}" {{ old('origin', $workstation->origin_account_id) == $account->id ? 'selected' : '' }}>
                                                                    {{ $account->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td style="width: 15%">
                                                        <div class="custom-control custom-switch custom-switch-success custom-control-inline">
                                                            <input type="checkbox" class="custom-control-input" id="customSwitch1" name="automatic_depreciation" value="1" {{ old('automatic_depreciation', $workstation->automatic_depreciation) ? 'checked' : '' }}>
                                                            <label class="custom-control-label" for="customSwitch1"></label>
                                                            <span class="switch-label">إهلاك تلقائي</span>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <br><hr>

                                <div class="form-group col-md-6"></div>

                                <div class="form-group col-md-6">
                                    <div class="d-flex justify-content-between p-1" style="background: #CCF5FA;">
                                        <strong>إجمالي التكلفة : </strong>
                                        <strong class="total-cost">{{ number_format($workstation->total_cost, 2) }} ر.س</strong>
                                        <input type="hidden" name="total_cost" value="{{ old('total_cost', $workstation->total_cost) }}">
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
        // Function to calculate total cost
        function calculateTotalCost() {
            let totalCost = 0;

            // Calculate expenses
            document.querySelectorAll('[name="cost_expenses[]"]').forEach(input => {
                totalCost += parseFloat(input.value) || 0;
            });

            // Calculate wages
            const wages = parseFloat(document.querySelector('[name="cost_wages"]').value) || 0;
            totalCost += wages;

            // Calculate origin
            const origin = parseFloat(document.querySelector('[name="cost_origin"]').value) || 0;
            totalCost += origin;

            // Update the total cost display
            document.querySelector('.total-cost').textContent = totalCost.toFixed(2) + ' ر.س';
            document.querySelector('input[name="total_cost"]').value = totalCost.toFixed(2);
        }

        // Function to toggle section visibility
        function toggleSection(sectionId) {
            const section = document.getElementById(sectionId);
            if (section.style.display === "none") {
                section.style.display = "block";
            } else {
                section.style.display = "none";
            }
        }

        // فتح الأقسام تلقائيًا إذا كانت تحتوي على بيانات عند تحميل الصفحة
        document.addEventListener("DOMContentLoaded", function () {
            function openSectionsWithData() {
                const sections = {
                    rawMaterials: document.querySelectorAll('[name="cost_expenses[]"]').length > 0,
                    expenses: document.querySelector('[name="cost_wages"]').value.trim() !== "",
                    manufacturing: document.querySelector('[name="cost_origin"]').value.trim() !== ""
                };

                for (const [sectionId, hasData] of Object.entries(sections)) {
                    if (hasData) {
                        document.getElementById(sectionId).style.display = "block";
                    }
                }
            }

            openSectionsWithData(); // استدعاء الدالة عند تحميل الصفحة
        });

        // Function to update raw material count
        function updateRawMaterialCount() {
            const rowCount = document.querySelectorAll('#itemsTable tbody tr').length;
            document.getElementById('rawMaterialCount').textContent = rowCount;
        }

        // Add row to expenses table
        document.getElementById('addRow').addEventListener('click', function () {
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td><input type="number" name="cost_expenses[]" class="form-control unit-price" oninput="calculateTotalCost()"></td>
                <td>
                    <select name="account_expenses[]" class="form-control select2 product-select">
                        <option value="" disabled selected>-- اختر الحساب --</option>
                        @foreach ($accounts as $account)
                            <option value="{{ $account->id }}">{{ $account->name }}</option>
                        @endforeach
                    </select>
                </td>
                <td style="width: 10px">
                    <button type="button" class="btn btn-outline-danger btn-sm removeRow"><i class="fa fa-trash"></i></button>
                </td>
            `;
            document.querySelector('#itemsTable tbody').appendChild(newRow);
            updateRawMaterialCount();
        });

        // Remove row from expenses table
        document.querySelector('#itemsTable').addEventListener('click', function (e) {
            if (e.target.classList.contains('removeRow')) {
                const row = e.target.closest('tr');
                if (document.querySelectorAll('#itemsTable tbody tr').length > 1) {
                    row.remove();
                    updateRawMaterialCount();
                    calculateTotalCost();
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
    </script>
@endsection
