@extends('master')

@section('title')
    المخزون
@stop

@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">ادارة المنتجات</h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="">الرئيسيه</a>
                            </li>
                            <li class="breadcrumb-item active">تعديل منتج
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="content-body">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <div>
                        <label>الحقول التي عليها علامة <span style="color: red">*</span> الزامية</label>
                    </div>

                    <div>
                        <a href="{{ route('products.index') }}" class="btn btn-outline-danger">
                            <i class="fa fa-ban"></i>الغاء
                        </a>
                        <button type="submit" form="products_form" class="btn btn-outline-primary">
                            <i class="fa fa-save"></i>تحديث
                        </button>
                    </div>

                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        @if($product == "products")
                        <h4 class="card-title">تفاصيل المنتج</h4>
                        @else
                        <h4 class="card-title">تفاصيل الخدمة</h4>
                        @endif
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form id="products_form" class="form form-vertical" action="{{  route('products.update',$product->id)  }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-8">
                                            <div class="form-group">
                                                <label for="first-name-vertical">الاسم <span style="color: red">*</span></label>
                                                <input type="text" id="first-name-vertical" class="form-control" name="name" value="{{ old('name',$product->name) }}">
                                                @error('name')
                                                <span class="text-danger" id="basic-default-name-error" class="error">
                                                    {{ $message }}
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="email-id-vertical">الرقم التسلسلي</label>
                                                <input type="text" id="email-id-vertical" class="form-control"name="serial_number" value="{{ old('serial_number',$product->serial_number) }}">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="email-id-vertical">الوصف</label>
                                                <textarea name="description" class="form-control" id="basicTextarea" rows="3">{{ old('description',$product->description) }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="password-vertical">الصور</label>
                                                <input type="file" name="images" class="form-control" name="contact">
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="first-name-vertical">التصنيف</label>
                                                        <select name="category_id" class="form-control">
                                                            <option value="">-- اختر التصنيف --</option>
                                                            @foreach ($categories as $category)
                                                                <option value="{{ $category->id }}" {{ old('category_id',$product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="email-id-vertical">الماركة</label>
                                                        <input type="text" id="email-id-vertical" class="form-control" name="brand" value="{{ old('brand',$product->brand) }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="first-name-vertical">Sales Account</label>
                                                        <input type="text" id="first-name-vertical" class="form-control" name="sales_account" value="{{ old('sales_account',$product->sales_account) }}">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="email-id-vertical">Sales Cost Account</label>
                                                        <input type="text" id="email-id-vertical" class="form-control" name="sales_account" value="{{ old('sales_cost_account',$product->sales_cost_account) }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="first-name-vertical">المورد</label>
                                                        <input type="number" id="first-name-vertical" class="form-control"name="supplier_id" value="{{ old('supplier_id',$product->supplier_id) }}">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="email-id-vertical">باركود</label>
                                                        <input type="text" id="email-id-vertical" class="form-control" name="barcode" value="{{ old('barcode',$product->barcode) }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-12">
                                            <fieldset class="checkbox">
                                                <div class="vs-checkbox-con vs-checkbox-primary">
                                                    <input type="checkbox" name="available_online" {{ $product->available_online == 1 ? 'checked' : '' }} id="available_online" onchange="remove_disabled_ckeckbox()">
                                                    <span class="vs-checkbox">
                                                        <span class="vs-checkbox--check">
                                                            <i class="vs-icon feather icon-check"></i>
                                                        </span>
                                                    </span>
                                                    <span class="">متاح اون لاين</span>
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="form-group col-12">
                                            <fieldset class="checkbox">
                                                <div class="vs-checkbox-con vs-checkbox-primary">
                                                    <input type="checkbox" name="featured_product" {{ $product->featured_product == 1 ? 'checked' : '' }}  id="featured_product">
                                                    <span class="vs-checkbox">
                                                        <span class="vs-checkbox--check">
                                                            <i class="vs-icon feather icon-check"></i>
                                                        </span>
                                                    </span>
                                                    <span class="">منتج مميز</span>
                                                </div>
                                            </fieldset>
                                        </div>

                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">تفاصيل التسعير</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="first-name-vertical">سعر الشراء</label>
                                                        <input type="text" id="first-name-vertical" class="form-control" name="purchase_price" value="{{ old('purchase_price',$product->purchase_price) }}">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="email-id-vertical">سعر البيع</label>
                                                        <input type="text" id="email-id-vertical" class="form-control" name="sale_price" value="{{ old('sale_price',$product->sale_price) }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="first-name-vertical">الضريبه الاولى</label>
                                                        <select class="form-control" id="basicSelect" name="tax1">
                                                            <option value="">اختر ضريبة</option>
                                                            <option value="1" {{ old('tax1') == 1 ? 'selected' : '' }}>القيمة المضافة</option>
                                                            <option value="2" {{ old('tax1') == 2 ? 'selected' : '' }}>صفرية</option>
                                                            <option value="3" {{ old('tax1') == 3 ? 'selected' : '' }}>قيمة مضافة</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="email-id-vertical">الضريبه الثانية</label>
                                                        <select class="form-control" id="basicSelect" name="tax2">
                                                            <option value="">اختر ضريبة</option>
                                                            <option value="1" {{ old('tax2') == 1 ? 'selected' : '' }}>القيمة المضافة</option>
                                                            <option value="2" {{ old('tax2') == 2 ? 'selected' : '' }}>صفرية</option>
                                                            <option value="3" {{ old('tax2') == 3 ? 'selected' : '' }}>قيمة مضافة</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="first-name-vertical">اقل سعر بيع</label>
                                                        <input type="text" id="first-name-vertical" class="form-control" name="min_sale_price" value="{{ old('min_sale_price',$product->min_sale_price) }}">
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="form-group">
                                                        <label>الخصم</label>
                                                        <input type="text" id="email-id-vertical" class="form-control" name="discount" value="{{ old('discount',$product->discount) }}">
                                                    </div>
                                                </div>
                                                <div class="col-2">
                                                    <div class="form-group">
                                                        <label for="email-id-vertical">نوع الخصم</label>
                                                        <select class="form-control" id="basicSelect" name="discount_type">
                                                            <option value="1" {{ old('discount_type') == 1 ? 'selected' : '' }}>%</option>
                                                            <option value="2" {{ old('discount_type') == 2 ? 'selected' : '' }}>$</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="first-name-vertical">هامش الربح نسبه مئوية</label>
                                                        <input type="text" id="first-name-vertical" class="form-control" name="profit_margin" value="{{ old('profit_margin',$product->profit_margin) }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        @if($product == "products")
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">ادارة المخزون</h4>
            </div>
            <div class="card-content">
                <div class="card-body">
                        <div class="form-body">

                            <div class="row">
                                <div class="form-group col-12">
                                    <fieldset class="checkbox">
                                        <div class="vs-checkbox-con vs-checkbox-primary">
                                            <input type="checkbox" id="ProductTrackStock" onchange="remove_disabled()">
                                            <span class="vs-checkbox">
                                                <span class="vs-checkbox--check">
                                                    <i class="vs-icon feather icon-check"></i>
                                                </span>
                                            </span>
                                            <span class="">تتبع المخزون</span>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="first-name-vertical">نوع التتبع</label>
                                                <select disabled class="form-control ProductTrackingInput" name="track_inventory">
                                                    <option value="0" {{ old('track_inventory') == 0 ? 'selected' : '' }}>الرقم التسلسلي</option>
                                                    <option value="1" {{ old('track_inventory') == 1 ? 'selected' : '' }}>رقم الشحنة</option>
                                                    <option value="2" {{ old('track_inventory') == 2 ? 'selected' : '' }}>تاريخ الانتهاء</option>
                                                    <option value="3" {{ old('track_inventory') == 3 ? 'selected' : '' }}>رقم الشحنة وتاريخ الانتهاء</option>
                                                    <option value="4" {{ old('track_inventory') == 4 ? 'selected' : '' }} selected="selected">الكمية فقط</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="email-id-vertical"> نبهني عند وصول الكمية إلى أقل من !</label>
                                                <input disabled type="number" value="{{ old('low_stock_alert',$product->low_stock_alert) }}" class="form-control ProductTrackingInput" name="low_stock_alert">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                </div>
            </div>
        </div>
       @endif

        <div class="card">
            <div class="card-header">
                <h4 class="card-title">خيارات اكثر</h4>
            </div>
            <div class="card-content">
                <div class="card-body">
                        <div class="form-body">

                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="email-id-vertical">ملاخظات داخلية</label>
                                        <textarea class="form-control" id="basicTextarea" name="Internal_notes" rows="3">{{ old('Internal_notes',$product->Internal_notes) }}</textarea>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="form-group">
                                        <label>وسوم</label>
                                        <input type="text" id="email-id-vertical" class="form-control" name="tags" value="{{ old('tags',$product->tags) }}">
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="first-name-vertical">الحالة</label>
                                        <select class="form-control" id="basicSelect" name="status">
                                            <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>نشط</option>
                                            <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>موقوف</option>
                                            <option value="2" {{ old('status') == 2 ? 'selected' : '' }}>غير نشط</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

@endsection

@section('scripts')

<script>
    function remove_disabled() {
        if (document.getElementById("ProductTrackStock").checked) {
            disableForm(false);
        }
        if (!document.getElementById("ProductTrackStock").checked) {
            disableForm(true);
        }
    }

    function disableForm(flag) {
        var elements = document.getElementsByClassName("ProductTrackingInput");
        for (var i = 0, len = elements.length; i < len; ++i) {
            elements[i].readOnly = flag;
            elements[i].disabled = flag;
        }
    }
</script>
<!----------------------------------------------->
<script>
    function remove_disabled_ckeckbox() {
        if(document.getElementById("available_online").checked)
            document.getElementById("featured_product").disabled = false;
        else
        document.getElementById("featured_product").disabled = true;
    }
</script>

@endsection
