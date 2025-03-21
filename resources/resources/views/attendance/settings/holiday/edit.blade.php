@extends('master')

@section('title', 'تعديل قوائم العطلات')

@section('content')
    <!-- Header Section -->
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">تعديل قوائم العطلات</h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">الرئيسية</a></li>
                            <li class="breadcrumb-item active">تعديل</li>
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
                    <a href="{{ route('holiday_lists.index') }}" class="btn btn-outline-danger">
                        <i class="fa fa-ban"></i> إلغاء
                    </a>
                    <button type="submit" form="editHolidayForm" class="btn btn-outline-primary">
                        <i class="fa fa-save"></i> تحديث
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Section -->
    <div class="card">
        <div class="card-body">
            <h4 class="mb-4 p-1" style="background: #f8f8f8">معلومات قائمة العطلات</h4>
            <form id="editHolidayForm" method="POST" action="{{ route('holiday_lists.update', $holiday_list->id) }}">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <label for="employee" class="form-label">الاسم <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="application-date" name="name" value="{{ old('name', $holiday_list->name) }}">
                    </div>
                </div>
                <br><br>
                <h4 class="mb-4 p-1" style="background: #f8f8f8">ايام العطلات</h4>
                <div class="col-md-6">
                    <p>عدد العطلات المختارة: <strong id="holidayCount">{{ $holiday_list->holidays->count() }}</strong></p>
                </div>
                <table class="table table-striped">
                    <thead class="table-light">
                        <tr>
                            <th>الرقم المتسلسل</th>
                            <th>التاريخ</th>
                            <th>مسمى</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="holidayTable">
                        @foreach ($holiday_list->holidays as $index => $holiday)
                            <tr>
                                <td style="width: 10%">{{ $index + 1 }}</td>
                                <td><input type="date" class="form-control" name="holiday_date[]" value="{{ $holiday->holiday_date }}"></td>
                                <td><input type="text" class="form-control" name="named[]" value="{{ $holiday->named }}"></td>
                                <td style="width: 10%">
                                    <button type="button" class="btn btn-outline-danger btn-sm remove-row">إزالة <i class="fa fa-minus-circle"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="row">
                    <div class="col-md-6">
                        <button type="button" id="addRow" class="btn btn-outline-success btn-sm">اضافة <i class="fa fa-plus-circle"></i></button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const holidayTable = document.getElementById('holidayTable');
        const holidayCount = document.getElementById('holidayCount');
        let rowCount = holidayTable.rows.length;

        // Function to update holiday count
        function updateHolidayCount() {
            holidayCount.textContent = holidayTable.rows.length;
        }

        // Add Row Functionality
        document.getElementById('addRow').addEventListener('click', function () {
            rowCount++;
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td style="width: 10%">${rowCount}</td>
                <td><input type="date" class="form-control" name="holiday_date[]"></td>
                <td><input type="text" class="form-control" name="named[]"></td>
                <td style="width: 10%">
                    <button type="button" class="btn btn-outline-danger btn-sm remove-row">إزالة <i class="fa fa-minus-circle"></i></button>
                </td>
            `;
            holidayTable.appendChild(newRow);
            updateHolidayCount();
        });

        // Remove Row Functionality
        holidayTable.addEventListener('click', function (e) {
            if (e.target.classList.contains('remove-row') || e.target.closest('.remove-row')) {
                const row = e.target.closest('tr');
                row.remove();
                updateHolidayCount();
            }
        });
    });
</script>
@endsection
