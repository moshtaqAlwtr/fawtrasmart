@extends('master')

@section('title')
    أعدادات فواتير الشراء
@stop

@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">أعدادات فواتير الشراء</h2>
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
    <div class="card mb-3">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div>
                    <label>الحقول التي عليها علامة <span style="color: red">*</span> الزامية</label>
                </div>
                <div>
                    <a href="{{ route('Assets.index') }}" class="btn btn-outline-danger">
                        <i class="fa fa-ban"></i> إلغاء
                    </a>
                    <button type="submit" class="btn btn-outline-primary">
                        <i class="fa fa-save"></i> حفظ
                    </button>
                </div>
            </div>
        </div>
    </div>



    <div class="card my-5">
        <div class="card-body">
        <form>
            <!-- رقم فاتورة الشراء -->
            <div class="mb-3">
                <label for="invoice-number" class="form-label fw-bold">رقم فاتورة الشراء التالي</label>
                <input type="text" class="form-control" id="invoice-number" placeholder="1">
            </div>

            <!-- خيارات الدعم -->
            <div class="mb-3">
                <label for="support-options" class="form-label fw-bold">خيارات الخصم</label>
                <select class="form-control" id="support-options">
                    <option value="">كلاهما</option>
                    <option value="1">أجمالي الخصومات</option>
                    <option value="2">الخصم على مستوى البند</option>
                </select>
            </div>

            <!-- الخيارات -->
            <div class="vs-checkbox-con vs-checkbox-primary mb-1">
                                        <input name="sales_edit_delete_own_quotes" type="checkbox" class="permission-checkbox-sales permission-main-checkbox">
                                        <span class="vs-checkbox">
                                            <span class="vs-checkbox--check">
                                                <i class="vs-icon feather icon-check"></i>
                                            </span>
                                        </span>
                                        <span class="">
                                        تحديث أسعار المنتجات بعد فاتورة الشراء</span>
                                    </div>
            <div class="vs-checkbox-con vs-checkbox-primary mb-1">
                                        <input name="sales_edit_delete_own_quotes" type="checkbox" class="permission-checkbox-sales permission-main-checkbox">
                                        <span class="vs-checkbox">
                                            <span class="vs-checkbox--check">
                                                <i class="vs-icon feather icon-check"></i>
                                            </span>
                                        </span>
                                        <span class="">
                                        الدفع التلقائي لفواتير الشراء إذا كان لدى المورد رصيد متاح</span>
                                    </div>
                                    <div class="vs-checkbox-con vs-checkbox-primary mb-1">
                                        <input name="sales_edit_delete_own_quotes" type="checkbox" class="permission-checkbox-sales permission-main-checkbox">
                                        <span class="vs-checkbox">
                                            <span class="vs-checkbox--check">
                                                <i class="vs-icon feather icon-check"></i>
                                            </span>
                                        </span>
                                        <span class="">
                                        إجعل فواتير المشتريات مدفوعه بالفعل افتراضياً</span>
                                    </div>
                                    <div class="vs-checkbox-con vs-checkbox-primary mb-1">
                                        <input name="sales_edit_delete_own_quotes" type="checkbox" class="permission-checkbox-sales permission-main-checkbox">
                                        <span class="vs-checkbox">
                                            <span class="vs-checkbox--check">
                                                <i class="vs-icon feather icon-check"></i>
                                            </span>
                                        </span>
                                        <span class="">
                                        إجعل فواتير المشتريات مستلمة بالفعل افتراضياً</span>
                                    </div>

            <!-- باقي الخيارات -->
            <div class="vs-checkbox-con vs-checkbox-primary mb-1">
                                        <input name="sales_edit_delete_own_quotes" type="checkbox" class="permission-checkbox-sales permission-main-checkbox">
                                        <span class="vs-checkbox">
                                            <span class="vs-checkbox--check">
                                                <i class="vs-icon feather icon-check"></i>
                                            </span>
                                        </span>
                                        <span class="">
                                        إعطاء طلبات الشراء حالات يدوية
</span>
                                    </div>
                                    <div class="vs-checkbox-con vs-checkbox-primary mb-1">
                                        <input name="sales_edit_delete_own_quotes" type="checkbox" class="permission-checkbox-sales permission-main-checkbox">
                                        <span class="vs-checkbox">
                                            <span class="vs-checkbox--check">
                                                <i class="vs-icon feather icon-check"></i>
                                            </span>
                                        </span>
                                        <span class="">
                                        إعطاء طلبات عروض الأسعار حالات يدوية</span>
                                    </div>
                                    <div class="vs-checkbox-con vs-checkbox-primary mb-1">
                                        <input name="sales_edit_delete_own_quotes" type="checkbox" class="permission-checkbox-sales permission-main-checkbox">
                                        <span class="vs-checkbox">
                                            <span class="vs-checkbox--check">
                                                <i class="vs-icon feather icon-check"></i>
                                            </span>
                                        </span>
                                        <span class="">
                                        إعطاء عروض أسعار المشتريات حالات يدوية</span>
                                    </div>
                                    <div class="vs-checkbox-con vs-checkbox-primary mb-1">
                                        <input name="sales_edit_delete_own_quotes" type="checkbox" class="permission-checkbox-sales permission-main-checkbox">
                                        <span class="vs-checkbox">
                                            <span class="vs-checkbox--check">
                                                <i class="vs-icon feather icon-check"></i>
                                            </span>
                                        </span>
                                        <span class="">
                                        إعطاء أوامر الشراء حالات يدوية</span>
                                    </div>
                                    <div class="vs-checkbox-con vs-checkbox-primary mb-1">
                                        <input name="sales_edit_delete_own_quotes" type="checkbox" class="permission-checkbox-sales permission-main-checkbox">
                                        <span class="vs-checkbox">
                                            <span class="vs-checkbox--check">
                                                <i class="vs-icon feather icon-check"></i>
                                            </span>
                                        </span>
                                        <span class="">
                                        إعطاء فواتير الشراء حالات يدوية</span>
                                    </div>
                                    <div class="vs-checkbox-con vs-checkbox-primary mb-1">
                                        <input name="sales_edit_delete_own_quotes" type="checkbox" class="permission-checkbox-sales permission-main-checkbox">
                                        <span class="vs-checkbox">
                                            <span class="vs-checkbox--check">
                                                <i class="vs-icon feather icon-check"></i>
                                            </span>
                                        </span>
                                        <span class="">
                                        تفعيل التسوية</span>
                                    </div>
                                    <div class="vs-checkbox-con vs-checkbox-primary mb-1">
                                        <input name="sales_edit_delete_own_quotes" type="checkbox" class="permission-checkbox-sales permission-main-checkbox">
                                        <span class="vs-checkbox">
                                            <span class="vs-checkbox--check">
                                                <i class="vs-icon feather icon-check"></i>
                                            </span>
                                        </span>
                                        <span class="">
                                        تفعيل الأشعار الدائن</span>
                                    </div>
                                    <div class="vs-checkbox-con vs-checkbox-primary mb-1">
                                        <input name="sales_edit_delete_own_quotes" type="checkbox" class="permission-checkbox-sales permission-main-checkbox">
                                        <span class="vs-checkbox">
                                            <span class="vs-checkbox--check">
                                                <i class="vs-icon feather icon-check"></i>
                                            </span>
                                        </span>
                                        <span class="">
                                        وصف مخصص للقيود اليومية</span>
                                    </div>
       
        </form>
    </div>

@endsection
