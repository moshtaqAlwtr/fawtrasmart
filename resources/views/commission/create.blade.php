@extends('master')

@section('title')
    اضافة قاعدة عمولة
@stop

<style>
    hr {
        border: none;
        height: 2px;
        background-color: #ac9191; /* اللون الأسود */
        width: 100%; /* عرض الخط */
        margin: 20px auto; /* للمحاذاة التلقائية */
    }
</style>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<!-- مكتبة Select2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

<!-- تأكد من أنك قد أضفت مكتبة Select2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<script>
    let productsOptions = `@foreach($products as $product)
        <option value="{{ $product->id }}">{{ $product->name }}</option>
    @endforeach`;
</script>


@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">اضافة قاعدة عمولة</h2>
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

    <div class="content-body">
        <form id="clientForm" action="{{ route('commission.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <div>
                            <label>الحقول التي عليها علامة <span style="color: red">*</span> الزامية</label>
                        </div>

                        <div>
                            <a href="{{ route('commission.index') }}" class="btn btn-outline-danger">
                                <i class="fa fa-ban"></i>الغاء
                            </a>
                            <button type="submit" class="btn btn-outline-primary">
                                <i class="fa fa-save"></i>حفظ
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">معلومات قواعد العمولة</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="form-body">
                                    <div class="row">
                                        <!-- الاسم -->
                                        <div class="col-md-6 mb-3">
                                            <div class="form-group">
                                                <label for="text">الاسم</label>
                                                <div class="position-relative has-icon-left">
                                                    <input type="text" id="name" class="form-control" name="name">
                                                    <div class="form-control-position"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- الحالة -->
                                        <div class="col-md-6 mb-3">
                                            <div class="form-group">
                                                <label for="printing_method">الحالة</label>
                                                <div class="position-relative has-icon-left">
                                                    <select class="form-control" id="printing_method" name="status">
                                                        <option value="active">نشط</option>
                                                        <option value="deactive">غير نشط</option>
                                                    </select>
                                                    <div class="form-control-position"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- الفترة -->
                                    <div class="col-md-6 mb-3">
                                            <div class="form-group">
                                                <label for="printing_method">الفترة</label>
                                                <div class="position-relative has-icon-left">
                                                    <select class="form-control" id="printing_method" name="period">
                                                        <option value="quarterly">ربع سنوي</option>
                                                        <option value="yearly">سنوي</option>
                                                        <option value="monthly">شهري</option>
                                                    </select>
                                                    <div class="form-control-position"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- حساب العمولة -->
                                        <div class="col-md-6 mb-3">
                                            <div class="form-group">
                                                <label for="printing_method">حساب العمولة</label>
                                                <div class="position-relative has-icon-left">
                                                    <select class="form-control" id="printing_method" name="commission_calculation">
                                                        <option value="fully_paid">فواتير مدفوعة بالكامل</option>
                                                        <option value="partially_paid">فواتير مدفوعة جزئيا</option>
                                                    </select>
                                                    <div class="form-control-position"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- الموظفين -->
                                 <div class="col-md-6 mb-3">
                                            <div class="form-group">
                                                <label for="employees">الموظفين</label>
                                                <select id="employees" class="form-control select2" name="employee_id[]" multiple="multiple">
                                                    @foreach($employees as $employee)
                                                        <option value="{{ $employee->id }}">{{ $employee->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                </div>

                        
                                      

                                        <!-- العملة -->
                                        <div class="col-md-6 mb-3">
                                            <div class="form-group">
                                                <label for="currency">العملة</label>
                                                <div class="position-relative has-icon-left">
                                                    <select class="form-control" id="currency" name="currency">
                                                        <option value="SAR" {{ old('currency') == 'SAR' ? 'selected' : '' }}>SAR</option>
                                                        <option value="USD" {{ old('currency') == 'USD' ? 'selected' : '' }}>USD</option>
                                                        <option value="EUR" {{ old('currency') == 'EUR' ? 'selected' : '' }}>EUR</option>
                                                    </select>
                                                    <div class="form-control-position"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <hr>

                                        <!-- اضافة بند -->
                                        <div class="col-md-12 mb-3">
                                            <div class="card">
                                                <div class="card-content">
                                                    <div class="card-body">
                                                        <input type="hidden" id="products-data" value="">
                                                        <div class="table-responsive">
                                                            <table class="table" id="items-table">
                                                                <thead>
                                                                    <tr>
                                                                        <th>البند</th>
                                                                        <th></th>
                                                                        <th>نسبة العمولة</th>
                                                                        <th>الضبط</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr class="item-row">
                                                                        <td style="width:18%">
                                                                            <select name="items[0][product_id]" class="form-control product-select">
                                                                                <option value="">اختر البند</option>
                                                                                <option value="0">كل المنتجات</option>
                                                                                <option value="1">البند</option>
                                                                            </select>
                                                                        </td>
                                                                        <td>
                                                                            <!-- الـ Select2 مع الخيارات للمنتجات -->
                                                                            <select name="items[0][product_id]" class="form-control product-search">
                                                                                <option value="">اختر البند</option>
                                                                                @foreach($products as $product)
                                                                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </td>
                                                                        <td>
                                                                            <input type="number" name="items[0][commission_percentage]" class="form-control tax">
                                                                        </td>
                                                                        <td>
                                                                            <button type="button" class="btn btn-danger btn-sm remove-row">
                                                                                <i class="fa fa-trash"></i>
                                                                            </button>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                                
                                                                
                                                                <tfoot>
                                                                    <tr>
                                                                        <td colspan="9" class="text-right">
                                                                            <button type="button" id="add-row" class="btn btn-success">
                                                                                <i class="fa fa-plus"></i> إضافة صف
                                                                            </button>
                                                                        </td>
                                                                    </tr>
                                                                </tfoot>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- نوع الهدف -->
                                        <div class="col-md-6">
                                            <div class="position-relative">
                                                <div class="input-group form-group hide-required-star has-success hide-backend-error">
                                                    <div class="input-group-prepend w-100">
                                                        <div class="input-group-text w-100">
                                                            <div class="custom-control custom-radio p-0 w-100 input-error-target">
                                                                <div class="custom-control custom-radio custom-control-inline mx-0">
                                                                    <input id="target_revenue_radio" class="custom-control-input target_type" required="required" checked="checked" name="target_type" type="radio" value="amount">
                                                                    <label for="target_revenue_radio" class="custom-control-label">المبلغ المستهدف <span class="required">*</span></label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <input id="target_amount_revenue" class="form-control" min="0" step="0.01" placeholder="المبلغ المستهدف" required="required" lang="en" name="value" type="number">
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="position-relative">
                                                <div class="input-group form-group hide-required-star hide-backend-error">
                                                    <div class="input-group-prepend w-100">
                                                        <div class="input-group-text w-100">
                                                            <div class="custom-control custom-radio p-0 w-100 input-error-target">
                                                                <div class="custom-control custom-radio custom-control-inline mx-0">
                                                                    <input id="target_volume_radio" class="custom-control-input target_type" required="required" name="target_type" type="radio" value="quantity">
                                                                    <label for="target_volume_radio" class="custom-control-label">الكمية المستهدفة <span class="required">*</span></label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <input id="target_amount_volume" class="form-control" placeholder="ادخل قيمة موجبة" required="required" lang="en" name="value" type="number">
                                            </div>
                                        </div>
                                        

                                        <!-- الملاحظات -->
                                        <div class="col-md-12 mb-3">
                                            <label for="notes">الملاحظات</label>
                                            <textarea class="form-control" id="notes" name="notes" rows="5" style="resize: none;">{{ old('notes') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const targetVolumeRadio = document.getElementById('target_volume_radio');
        const targetRevenueRadio = document.getElementById('target_revenue_radio');
        const revenueInput = document.getElementById('target_amount_revenue');
        const volumeInput = document.getElementById('target_amount_volume');

        function toggleInputs() {
            if (targetRevenueRadio.checked) {
                revenueInput.disabled = false;
                revenueInput.readOnly = false;
                revenueInput.style.backgroundColor = ''; // إعادة لون الخلفية للوضع الطبيعي
                
                volumeInput.disabled = true;
                volumeInput.readOnly = true;
                volumeInput.style.backgroundColor = '#f2f2f2'; // تجميد الحقل الآخر
            } else if (targetVolumeRadio.checked) {
                volumeInput.disabled = false;
                volumeInput.readOnly = false;
                volumeInput.style.backgroundColor = ''; // إعادة لون الخلفية للوضع الطبيعي
                
                revenueInput.disabled = true;
                revenueInput.readOnly = true;
                revenueInput.style.backgroundColor = '#f2f2f2'; // تجميد الحقل الآخر
            }
        }

        // ضبط القيم عند تحميل الصفحة
        toggleInputs();

        // إضافة مستمعات الأحداث لتغيير الحقول عند تحديد نوع الهدف
        targetRevenueRadio.addEventListener('change', toggleInputs);
        targetVolumeRadio.addEventListener('change', toggleInputs);
    });
</script>



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function () {
        $('#add-row').click(function () {
            let rowCount = $('#items-table tbody tr').length;
            let newRow = `
                <tr class="item-row">
                    <td style="width:18%">
                        <select name="items[${rowCount}][product_id]" class="form-control product-select">
                            <option value="">اختر البند</option>
                            <option value="0">كل المنتجات</option>
                            ${productsOptions}
                        </select>
                    </td>
                    <td>
                        <select name="items[${rowCount}][product_id]" class="form-control product-search">
                            <option value="">اختر البند</option>
                            ${productsOptions}
                        </select>
                    </td>
                    <td>
                        <input type="number" name="items[${rowCount}][commission_percentage]" class="form-control tax">
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm remove-row">
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `;
            $('#items-table tbody').append(newRow);
        });

        $(document).on('click', '.remove-row', function () {
            $(this).closest('tr').remove();
        });
    });
</script>



<script>
    $(document).ready(function() {
        $('#employees').select2({
            placeholder: "ابحث عن الموظفين...",
            allowClear: true
        });
    });
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
    // عند تغيير قيمة القائمة المنسدلة
    $(document).on("change", ".product-select", function () {
        var selectedOption = $(this).val();
        var row = $(this).closest(".item-row"); // احصل على الصف الحالي
        var inputField = row.find('input[name$="[product_id]"]'); // حقل الإدخال التالي

        if (selectedOption === "0") {
            inputField.val("0").prop("disabled", true); // أدخل 0 وجمّد الحقل
        } else {
            inputField.val("").prop("disabled", false); // فك التجميد وإفراغ الحقل
        }
    });
});
</script>

<script>
    $(document).ready(function() {
        // تفعيل Select2 على العنصر
        $('.product-search').select2({
            placeholder: "اختر البند"
        });
    });
    </script>








