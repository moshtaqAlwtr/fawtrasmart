@extends('master')

@section('title')
    تعديل باقة
@stop

@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0"> تعديل باقة </h2>
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

    <div class="content-body">
        <div class="card mb-5">
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

        <form class="form mt-4">
            <div class="card" style="max-width: 90%; margin: 0 auto;">
                <h1>
                </h1>
                <div class="card-body">

                    <div class="form-body row mb-5">
                        <div class="form-group col-md-6 mb-3">
                            <label for="feedback2" class="">اسم <span class="text-danger">*</span></label>
                            <input type="text" id="feedback2" class="form-control" placeholder="الاسم"
                                name="commission_name">
                        </div>

                        <div class="form-group col-md-6 mb-3">
                            <label for="feedback1" class="">العضوية <span class="text-danger">*</span></label>
                            <select name="status" class="form-control" id="">
                                <option value="1">العضوية</option>
                                <option value="0">شحن الرصيد</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-body row mb-5">
                        <div class="form-group col-md-6 mb-3">
                            <label for="feedback1" class="">الحالة <span class="text-danger">*</span></label>
                            <select name="period" class="form-control" id="">
                                <option value="">نشط</option>
                                <option value="">غير نشط</option>
                            </select>
                        </div>

                        <div class="form-group col-md-6 mb-3">
                            <label for="feedback1" class="">السعر <span class="text-danger">*</span></label>
                            <input type="text" class="form-control">
                        </div>
                    </div>

                    <div class="form-body row mb-5">

                        <div class="form-group col-md-3 mb-3==">
                            <label for="feedback1" class="">الفترة <span class="text-danger">*</span></label>
                            <input type="text" class="form-control">
                        </div>

                        <div class="form-group col-md-3 mb-3">
                            <label for="feedback1" class="">الفترة <span class="text-danger">*</span></label>
                            <select name="currency" class="form-control" id="">
                                <option value="">سنويا</option>
                                <option value="">شهريا</option>
                                <option value="">يوميا</option>
                                <option value="">اسبوعيا</option>

                            </select>
                        </div>

                        <div class="form-group col-md-6 mb-3==">
                            <label for="feedback1" class="">الوصف <span class="text-danger">*</span></label>
                            <textarea name="description" id="" class="form-control"></textarea>
                        </div>

                    </div>
                </div>

            </div>

            <div class="card" style="max-width: 90%; margin: 0 auto; margin-top: 20px">
                <div class="card-body">
                    <div class="mt-4">
                        <h6>انواع الرصيد </h6>
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
                                    <tr>
                                        <td class="align-middle text-center">
                                            <li class="fas fa-grip-vertical text-muted"></li>
                                        </td>

                                        <td class="align-middle text-center">
                                            <div class="position-relative">
                                                <select name="item_type" class="form-control"
                                                    style="background-color: #fff3cd;">
                                                    <option value="">إختر نوع الرصيد</option>
                                                    <option value="all_products">نقاط الولاء</option>
                                                    <option value=""> <a href=" " class="btn btn-primary">
                                                            اضف نوع الرصيد</a>
                                                    </option>
                                                </select>

                                            </div>
                                        </td>


                                        <td>
                                            <input type="text" class="form-control" placeholder="ادخل القيمة"
                                                style="background-color: #fff3cd;">
                                        </td>
                                        <td class="align-middle text-center">
                                            <a href="javascript:void(0)" onclick="removeRow(this)"
                                                class="text-decoration-none">
                                                <i class="fas fa-minus-circle text-danger"></i>
                                                <span class="text-danger ms-2">إزالة</span>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr id="newRow" style="display: none; background-color: #fff7d6;">
                                        <td class="align-middle text-center">
                                            <i class="fas fa-grip-vertical text-muted"></i>
                                        </td>
                                        <td>
                                            <div class="position-relative">
                                                <select name="item_type" class="form-control">
                                                    <option value="">إختر نوع الرصيد</option>
                                                    <option value="all_products">نقاط الولاء</option>
                                                    <option value=""> <a href=" " class="btn btn-primary">
                                                            <li class="fas fa-plus"></li>
                                                            اضف نوع الرصيد
                                                        </a>
                                                </select>

                                            </div>
                                        </td>

                                        <td>
                                            <input type="text" class="form-control" placeholder="ادخل المبلغ">
                                        </td>
                                        <td class="align-middle text-center">
                                            <a href="javascript:void(0)" onclick="removeRow(this)"
                                                class="text-decoration-none">
                                                <i class="fas fa-minus-circle text-danger"></i>
                                                <span class="text-danger ms-2">إزالة</span>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr id="newRow" style="display: none; background-color: #fff7d6;">
                                        <td class="align-middle text-center">
                                            <i class="fas fa-grip-vertical text-muted"></i>
                                        </td>
                                        <td>
                                            <select name="item_type" class="form-control">
                                                <option value="">إختر البند</option>
                                                <option value="all_products">كل المنتجات</option>
                                                <option value="category">التصنيف</option>
                                                <option value="item">البند</option>
                                            </select>
                                        </td>
                                        <td>
                                            <button id="showFormButton" class="btn btn-success"><i
                                                    class="fas fa-plus-circle"></i> إضافة بند</button>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" placeholder="ادخل المبلغ">
                                        </td>
                                        <td class="align-middle text-center">
                                            <a href="javascript:void(0)" onclick="removeRow(this)"
                                                class="text-decoration-none">
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









    </div>




@endsection

@section('scripts')

    <script>
        document.getElementById('addRowButton').addEventListener('click', function() {
            const template = document.getElementById('newRow');
            const tbody = template.parentNode;
            const newRow = template.cloneNode(true);
            newRow.style.display = '';
            newRow.id = '';
            tbody.appendChild(newRow);
        });
    </script>
    <script>
        document.getElementById('showFormButton').addEventListener('click', function() {
            document.getElementById('additionalForm').style.display = 'block';
        });
    </script>
    <script>
        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            // Set duration as default
            document.getElementById('duration_radio').checked = true;
            document.getElementById('enddate_radio').checked = false;

            // Initial toggle of fields
            toggleFields();

            // Add event listeners to radio buttons
            document.getElementById('duration_radio').addEventListener('change', toggleFields);
            document.getElementById('enddate_radio').addEventListener('change', toggleFields);
        });

        function toggleFields() {
            const durationRadio = document.getElementById('duration_radio');
            const endDateRadio = document.getElementById('enddate_radio');

            // Get all duration inputs
            const durationInputs = document.querySelectorAll('#duration-inputs input, #duration-inputs select');
            const endDateInput = document.getElementById('end_date');

            if (durationRadio.checked) {
                // Enable duration inputs, disable end date
                durationInputs.forEach(input => {
                    input.removeAttribute('disabled');
                    input.style.backgroundColor = '#ffffff';
                });
                endDateInput.setAttribute('disabled', 'disabled');
                endDateInput.style.backgroundColor = '#e9ecef';
                endDateInput.value = '';
            } else {
                // Enable end date, disable duration inputs
                durationInputs.forEach(input => {
                    input.setAttribute('disabled', 'disabled');
                    input.style.backgroundColor = '#e9ecef';
                });
                endDateInput.removeAttribute('disabled');
                endDateInput.style.backgroundColor = '#ffffff';
            }
        }
    </script>
    <script>
        function removeRow(element) {
            $(element).closest('tr').fadeOut(300, function() {
                $(this).remove();
                // إذا كان هذا آخر صف، أضف صف جديد
                if ($('table tbody tr').length === 1) { // 1 لأن لدينا صف مخفي
                    addNewRow();
                }
            });
        }

        function addNewRow() {
            var newRow = $('#newRow').clone().removeAttr('id').removeAttr('style');
            $('table tbody').append(newRow);
        }
    </script>
    <style>
        .form-control {
            width: 100%;
        }
    </style>
@endsection
