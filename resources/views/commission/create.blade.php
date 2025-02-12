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
@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">اضافة قاعدة عمولة </h2>
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
        <form id="clientForm" action="{{ route('clients.store') }}" method="POST" enctype="multipart/form-data">
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
                                    <!-- الاسم-->
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="text">الاسم</label>
                                            <div class="position-relative has-icon-left">
                                                <input type="text" id="name" class="form-control" name="name"
                                                    value="">
                                                <div class="form-control-position">
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            <!-- الحالة-->
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="printing_method">الحالة</label>
                                            <div class="position-relative has-icon-left">
                                                <select class="form-control" id="printing_method" name="printing_method">
                                                    <option value="1">نشط</option>
                                                    <option value="2">غير نشط</option>
                                                </select>
                                                <div class="form-control-position">
                                                   
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                      <!-- الفترة-->
                                      <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="printing_method">الفترة</label>
                                            <div class="position-relative has-icon-left">
                                                <select class="form-control" id="printing_method" name="printing_method">
                                                    <option value="1">ربع سنوي </option>
                                                    <option value="2">سنوي </option>
                                                    <option value="2">شهري </option>
                                                </select>
                                                <div class="form-control-position">
                                                   
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                 
                                       <!-- حساب العنولة-->
                                       <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="printing_method">حساب العمولة</label>
                                            <div class="position-relative has-icon-left">
                                                <select class="form-control" id="printing_method" name="printing_method">
                                                    <option value="1"> فواتير مدفوعة بالكامل </option>
                                                    <option value="2">فواتير مدفوعة جزئيا </option>
                                                   
                                                </select>
                                                <div class="form-control-position">
                                                   
                                                </div>
                                            </div>
                                        </div>
                                    </div>
  <!-- الموظفين-->
  <div class="col-md-6 mb-3">
    <div class="form-group">
        <label for="text">الموظفين</label>
        <div class="position-relative has-icon-left">
            <input type="text" id="name" class="form-control" name="name"
                value="">
            <div class="form-control-position">
                
            </div>
        </div>
    </div>
</div>
                                <!-- العملات -->
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="printing_method">العملات</label>
                                        <div class="position-relative has-icon-left">
                                            <select class="form-control" id="printing_method" name="printing_method">
                                                <option value="1"></option>
                                                <option value="2"></option>
                                               
                                            </select>
                                            <div class="form-control-position">
                                               
                                            </div>
                                        </div>
                                    </div>
                                </div>

                          
                                
                                    <!-- العملة -->
                                    <div class="col-md-12 mb-3">
                                        <div class="form-group">
                                            <label for="currency">العملة</label>
                                            <div class="position-relative has-icon-left">
                                                <select class="form-control" id="currency" name="currency">
                                                    <option value="SAR"
                                                        {{ old('currency') == 'SAR' ? 'selected' : '' }}>SAR</option>
                                                    <option value="USD"
                                                        {{ old('currency') == 'USD' ? 'selected' : '' }}>USD</option>
                                                    <option value="EUR"
                                                        {{ old('currency') == 'EUR' ? 'selected' : '' }}>EUR</option>
                                                </select>
                                                <div class="form-control-position">
                                                    <i class="feather icon-credit-card"></i>
                                                </div>
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
                                                                <th>نسبة العمولة</th>
                                                                <th>الضبط </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr class="item-row">
                                                                <td style="width:18%">
                                                                    <select name="items[0][product_id]"
                                                                        class="form-control product-select ">
                                                                        <option value="">اختر البند</option>
                                                                        
                                                                            <optio></option>
                                                                      
                                                                    </select>
                                                                </td>
                                                              
                                                                
                                                                <td>
                                                                    <input type="number" name="items[0][tax_1]" class="form-control tax"
                                                                        value="15" min="0" max="100" step="0.01">
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

<div class="col-md-12 mb-3">
    <div class="px-4 pt-3">
        <div class="form-row">
            <div class="col-md-12">
                <div class="form-group mb-0">
                    <label class="control-label"> نوع الهدف <span class="required">*</span></label>
                </br>
                </div>
            </br>
        </br>
            </div>
            <div class="col-md-6">
                <div class="position-relative">
                    <div class="input-group form-group hide-required-star has-success hide-backend-error">
                        <div class="input-group-prepend w-100">
                            <div class="input-group-text w-100">
                                <div class="custom-control custom-radio p-0 w-100  input-error-target">


                                                <div class="custom-control custom-radio custom-control-inline mx-0">
<input id="target_revenue_radio" class="custom-control-input target_type" required="required" checked="checked" name="target_type" type="radio" value="revenue" data-parsley-multiple="target_type" data-parsley-id="28">
                    <label for="target_revenue_radio" class="custom-control-label">المبلغ المستهدف <span class="required">*</span>
    </label>
</div>
      

        <div class="invalid-message filled backend-error">
                    <span></span>
            </div>

    </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group" data-opacity="true" data-if="[{'.target_type':{'type':'equal', 'value':'target_revenue_checked'}}]" style="">
                    <div class="form-row">
                        <div class="col-md-12 form-group mb-3 mb-md-3  input-error-target">



            
                                                            <input class="form-control" min="0" step="0.01" data-parsley-errors-container="#target-revenue-errors" placeholder="المبلغ المستهدف" required="required" lang="en" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : ((event.charCode >= 48 &amp;&amp; event.charCode <= 57) || event.charCode == 46)" name="target_amount" type="number" value="">
        
        
            

    </div>


                        <div class="col-md-12">
                            <div id="target-revenue-errors" class="invalid-messages"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="position-relative">
                    <div class="input-group form-group hide-required-star hide-backend-error">
                        <div class="input-group-prepend w-100">
                            <div class="input-group-text w-100">
                                <div class="custom-control custom-radio p-0 w-100  input-error-target">


                                                <div class="custom-control custom-radio custom-control-inline mx-0">
<input id="target_volume_radio" class="custom-control-input target_type" required="required" name="target_type" type="radio" value="volume" data-parsley-multiple="target_type">
                    <label for="target_volume_radio" class="custom-control-label"> الكمية المستهدفة <span class="required">*</span>
    </label>
</div>
        
        <div class="invalid-message filled backend-error">
                    <span></span>
            </div>

    </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group form-group-icon">
                    <input class="form-control"  placeholder="ادخل قيمة موجبة" required="required" lang="en"  name="target_amount" type="number" value="">
        
        
                    <span></span>
            </div>


                </div>
            </div>
        </div>
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

            </form>
        </div>


    </div>
    </div>

    <!------------------------->


@endsection



<script>
    // تأكد من أن هذا السكربت يتم تحميله بعد DOM
    document.addEventListener('DOMContentLoaded', function () {
        const targetVolumeRadio = document.getElementById('target_volume_radio');
        const targetAmountInput = document.querySelector('input[name="target_amount"]');

        // عند تغيير الراديو، نتحقق إذا كان قد تم اختيار "الكمية المستهدفة"
        targetVolumeRadio.addEventListener('change', function () {
            if (targetVolumeRadio.checked) {
                targetAmountInput.disabled = false;  // تمكين الحقل
                targetAmountInput.parentElement.style.display = 'block';  // عرض الحقل
            }
        });

        const targetRevenueRadio = document.getElementById('target_revenue_radio');
        
        // عند تغيير الراديو، نتحقق إذا كان قد تم اختيار "المبلغ المستهدف"
        targetRevenueRadio.addEventListener('change', function () {
            if (targetRevenueRadio.checked) {
                targetAmountInput.disabled = true;  // تعطيل الحقل
                targetAmountInput.parentElement.style.display = 'none';  // إخفاء الحقل
            }
        });
    });
</script>

