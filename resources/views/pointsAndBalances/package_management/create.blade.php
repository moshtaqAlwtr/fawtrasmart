@extends('master')

@section('title')
    اضافة باقة
@stop

@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0"> اضافة باقة </h2>
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

    @include('layouts.alerts.success')
    @include('layouts.alerts.error')


    <div class="content-body">
        <form class="form mt-4" action="{{ route('PackageManagement.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
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

            <div class="card" style="max-width: 90%; margin: 0 auto;">
                <div class="card-body">
                    <div class="form-body row mb-5">
                        <div class="form-group col-md-6 mb-3">
                            <label for="feedback2" class="">اسم <span class="text-danger">*</span></label>
                            <input type="text" id="feedback2" class="form-control" placeholder="الاسم" name="commission_name">
                        </div>
                        <div class="form-group col-md-6 mb-3">
                            <label for="feedback1" class="">نوع ال <span class="text-danger">*</span></label>
                            <select name="members" class="form-control" id="">
                                <option value="1">العضوية</option>
                                <option value="2">شحن الرصيد</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-body row mb-5">
                        <div class="form-group col-md-6 mb-3">
                            <label for="feedback1" class="">الحالة <span class="text-danger">*</span></label>
                            <select name="status" class="form-control" id="">
                                <option value="1">نشط</option>
                                <option value="2">غير نشط</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6 mb-3">
                            <label for="feedback1" class="">السعر <span class="text-danger">*</span></label>
                            <input type="text" name="price" class="form-control" placeholder="السعر">
                        </div>
                    </div>

                    <div class="form-body row mb-5">
                        <div class="form-group col-md-3 mb-3">
                            <label for="feedback1" class="">الفترة <span class="text-danger">*</span></label>
                            <input type="text" name="duration" class="form-control" placeholder="الفترة">
                        </div>
                        <div class="form-group col-md-3 mb-3">
                            <label for="feedback1" class="">1 <span class="text-danger">*</span></label>
                            <select name="payment_rate" class="form-control" id="">
                                <option value="1">سنويا</option>
                                <option value="2">شهريا</option>
                                <option value="3">يوميا</option>
                                <option value="4">اسبوعيا</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6 mb-3">
                            <label for="feedback1" class="">الوصف <span class="text-danger">*</span></label>
                            <textarea name="description" id="" class="form-control" placeholder="الوصف"></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card" style="max-width: 90%; margin: 0 auto; margin-top: 20px">
                <div class="card-body">
                    <div class="mt-4">
                        <h6>انواع الرصيد</h6>
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="" style="background: #e9ecef">
                                    <tr>
                                        <th></th>
                                        <th>نوع الرصيد</th>
                                        <th colspan="2">ادخل قيمة الرصيد</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- الصف الأول -->
                                    <tr>
                                        <td class="align-middle text-center">
                                            <li class="fas fa-grip-vertical text-muted"></li>
                                        </td>
                                        <td class="align-middle text-center">
                                            <div class="position-relative">
                                                <select name="balance_types[0][id]" class="form-control" style="background-color: #fff3cd;">
                                                    <option value="">إختر نوع الرصيد</option>
                                                    @foreach ($balanceTypes as $balanceType)
                                                        <option value="{{ $balanceType->id }}">{{ $balanceType->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </td>
                                        <td>
                                            <input type="text" name="balance_types[0][balance_value]" class="form-control" placeholder="ادخل القيمة" style="background-color: #fff3cd;">
                                        </td>
                                        <td class="align-middle text-center">
                                            <a href="javascript:void(0)" onclick="removeRow(this)" class="text-decoration-none">
                                                <i class="fas fa-minus-circle text-danger"></i>
                                                <span class="text-danger ms-2">إزالة</span>
                                            </a>
                                        </td>
                                    </tr>
                                    <!-- الصف المخفي (يستخدم كقالب) -->
                                    <tr id="newRow" style="display: none; background-color: #fff7d6;">
                                        <td class="align-middle text-center">
                                            <i class="fas fa-grip-vertical text-muted"></i>
                                        </td>
                                        <td>
                                            <div class="position-relative">
                                                <select name="balance_types[][id]" class="form-control" style="background-color: #f8fcfc;">
                                                    <option value="">إختر نوع الرصيد</option>
                                                    @foreach ($balanceTypes as $balanceType)
                                                        <option value="{{ $balanceType->id }}">{{ $balanceType->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </td>
                                        <td>
                                            <input type="text" name="balance_types[][balance_value]" class="form-control" placeholder="ادخل المبلغ">
                                        </td>
                                        <td class="align-middle text-center">
                                            <a href="javascript:void(0)" onclick="removeRow(this)" class="text-decoration-none">
                                                <i class="fas fa-minus-circle text-danger"></i>
                                                <span class="text-danger ms-2">إزالة</span>
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="mb-5">
                                <a id="addRowButton" class="btn btn-success">
                                    <li class="fas fa-plus"></li>إضافة
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script>
        document.getElementById('addRowButton').addEventListener('click', function() {
            const template = document.getElementById('newRow');
            const tbody = template.parentNode;
            const newRow = template.cloneNode(true); // استنساخ الصف المخفي
            newRow.style.display = ''; // إظهار الصف الجديد
            newRow.id = ''; // إزالة الـ ID حتى لا يتكرر

            // تحديث أسماء الحقول للصف الجديد
            const index = tbody.querySelectorAll('tr').length - 1; // حساب الفهرس الجديد
            newRow.querySelector('select[name="balance_types[][id]"]').name = `balance_types[${index}][id]`;
            newRow.querySelector('input[name="balance_types[][balance_value]"]').name = `balance_types[${index}][balance_value]`;

            tbody.appendChild(newRow); // إضافة الصف الجديد إلى الجدول
        });

        function removeRow(element) {
            const row = element.closest('tr'); // الحصول على الصف المراد إزالته
            row.remove(); // إزالة الصف

            // إعادة ترقيم أسماء الحقول المتبقية
            const rows = document.querySelectorAll('table tbody tr');
            rows.forEach((row, index) => {
                row.querySelector('select[name^="balance_types"][name$="[id]"]').name = `balance_types[${index}][id]`;
                row.querySelector('input[name^="balance_types"][name$="[balance_value]"]').name = `balance_types[${index}][balance_value]`;
            });
        }

        document.querySelector('form').addEventListener('submit', function(event) {
            const balanceRows = document.querySelectorAll('table tbody tr');
            let valid = true;

            balanceRows.forEach(row => {
                const idField = row.querySelector('select[name^="balance_types"][name$="[id]"]');
                const valueField = row.querySelector('input[name^="balance_types"][name$="[balance_value]"]');

                if (!idField.value || !valueField.value) {
                    valid = false;
                }
            });

            if (!valid) {
                event.preventDefault(); // منع إرسال النموذج
                alert('يرجى ملء جميع الحقول المطلوبة في أنواع الرصيد.');
            }
        });
    </script>
@endsection
