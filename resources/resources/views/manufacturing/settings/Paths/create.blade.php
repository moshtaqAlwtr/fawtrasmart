@extends('master')

@section('title')
مسار الإنتاج
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
                    <h2 class="content-header-title float-left mb-0">مسار الإنتاج</h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="">الرئيسية</a></li>
                            <li class="breadcrumb-item active">إضافة</li>
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

            <form class="form-horizontal" action="{{ route('manufacturing.paths.store') }}" method="POST">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <div>
                                <label>الحقول التي عليها علامة <span style="color: red">*</span> إلزامية</label>
                            </div>
                            <div>
                                <a href="{{ route('manufacturing.paths.index') }}" class="btn btn-outline-danger">
                                    <i class="fa fa-ban"></i> إلغاء
                                </a>
                                <button type="submit" class="btn btn-outline-primary">
                                    <i class="fa fa-save"></i> حفظ
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <h4 class="card-title">معلومات مسار الإنتاج</h4>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="">الاسم <span style="color: red">*</span></label>
                                    <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="">كود <span style="color: red">*</span></label>
                                    <input type="text" class="form-control" name="code" value="{{ $serial_number }}">
                                </div>

                                <br>

                                <div class="form-group col-md-12">
                                    <p onclick="toggleSection('rawMaterials')" class="d-flex justify-content-between section-header" style="background: #DBDEE2; width: 100%;">
                                        <span class="p-1 font-weight-bold"><i class="feather icon-package mr-1"></i> المرحلة الإنتاجية (<span id="rawMaterialCount">1</span>)</span>
                                        <i class="feather icon-plus-circle p-1"></i>
                                    </p>
                                    <div id="rawMaterials">
                                        <table class="table table-striped" id="itemsTable">
                                            <thead style="background: #f8f8f8">
                                                <tr>
                                                    <th>رقم</th>
                                                    <th>الاسم</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td style="width: 10%" class="row-number">1</td>
                                                    <td><input type="text" name="stage_name[]" class="form-control unit-price"></td>
                                                    <td style="width: 10%">
                                                        <button type="button" class="btn btn-outline-danger btn-sm removeRow"><i class="fa fa-minus"></i></button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <hr>
                                        <div class="d-flex justify-content-between mt-2">
                                            <button type="button" class="btn btn-outline-success btn-sm" id="addRow"><i class="fa fa-plus"></i> إضافة</button>
                                        </div>
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
        function updateRawMaterialCount() {
            const rowCount = document.querySelectorAll('#itemsTable tbody tr').length;
            document.getElementById('rawMaterialCount').textContent = rowCount;
        }

        function updateRowNumbers() {
            document.querySelectorAll("#itemsTable tbody tr").forEach((row, index) => {
                row.querySelector(".row-number").textContent = index + 1;
            });
        }

        function toggleSection(sectionId) {
            const section = document.getElementById(sectionId);
            section.style.display = section.style.display === "none" ? "block" : "none";
        }

        document.addEventListener('DOMContentLoaded', function () {
            const itemsTable = document.getElementById('itemsTable').querySelector('tbody');
            const addRowButton = document.getElementById('addRow');

            addRowButton.addEventListener('click', function (e) {
                e.preventDefault();

                const newRow = document.createElement('tr');
                newRow.innerHTML = `
                    <td style="width: 10%" class="row-number"></td> <!-- سيتم تحديث الرقم لاحقًا -->
                    <td><input type="text" name="stage_name[]" class="form-control unit-price"></td>
                    <td style="width: 10%">
                        <button type="button" class="btn btn-outline-danger btn-sm removeRow"><i class="fa fa-minus"></i></button>
                    </td>
                `;

                itemsTable.appendChild(newRow);
                updateRawMaterialCount();
                updateRowNumbers();
            });

            itemsTable.addEventListener('click', function (e) {
                if (e.target.closest('.removeRow')) {
                    const row = e.target.closest('tr');
                    if (itemsTable.rows.length > 1) {
                        row.remove();
                        updateRawMaterialCount();
                        updateRowNumbers();
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
