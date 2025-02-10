@extends('master')

@section('title')
حالات طلبات التصنيع
@stop

@section('content')

<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-left mb-0">حالات طلبات التصنيع</h2>
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
    <!-- Header Section -->
    <div class="card">
      <div class="card-header bg-light">
        <strong>حالات طلبات التصنيع</strong>
      </div>
      <div class="card-body">
        <div class="d-flex align-items-center justify-content-between mb-3">
          <label for="toggleSwitch" class="form-label mb-0">تفعيل حالات طلبات التصنيع</label>
          <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" id="toggleSwitch">
          </div>
        </div>

        <!-- Table Section -->
        <div>
          <h6>الحالات اليدوية لطلبات التصنيع</h6>
          <table class="table table-bordered table-striped" id="statusTable">
            <thead class="table-light">
              <tr>
                <th style="width: 45%">الاسم</th>
                <th style="width: 50%">اللون</th>
                <th style="width: 5%">حذف</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>
                  <input type="text" class="form-control form-control-sm" placeholder="اسم الحالة">
                </td>
                <td>
                  <input type="color" class="form-control form-control-sm" value="#ffffff">
                </td>
                <td class="text-center">
                  <button class="btn btn-link text-danger p-0 deleteRow">
                    <i class="fas fa-trash"></i>
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
          <button class="btn btn-success btn-sm" id="addRowButton">إضافة +</button>
        </div>
      </div>
    </div>
</div>

<script>
  // إضافة صف جديد
  document.getElementById('addRowButton').addEventListener('click', function () {
    const tableBody = document.querySelector('#statusTable tbody');
    const newRow = document.createElement('tr');
    newRow.innerHTML = `
      <td>
        <input type="text" class="form-control form-control-sm" placeholder="اسم الحالة">
      </td>
      <td>
        <input type="color" class="form-control form-control-sm" value="#ffffff">
      </td>
      <td class="text-center">
        <button class="btn btn-link text-danger p-0 deleteRow">
          <i class="fas fa-trash"></i>
        </button>
      </td>
    `;
    tableBody.appendChild(newRow);
  });

  // حذف صف
  document.addEventListener('click', function (e) {
    if (e.target.closest('.deleteRow')) {
      const row = e.target.closest('tr');
      row.remove();
    }
  });
</script>

@endsection