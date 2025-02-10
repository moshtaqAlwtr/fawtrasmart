@extends('master')

@section('title')
    اضافة عرض
@stop

@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">اضافة عرض </h2>
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
    @include('layouts.alerts.error')
    @include('layouts.alerts.success')



    <div class="content-body">
        <div class="container-fluid">
            <form class="form-horizontal" action="{{ route('Offers.store') }}" method="POST" >
                @csrf



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

                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <h4 class="card-title"> تفاصيل العرض </h4>
                        </div>

                        <div class="card-body">
                            <div class="form-body row">

                                <div class="form-group col-md-12">
                                    <label for="">الاسم <span style="color: red">*</span></label>
                                    <input type="text" id="feedback2" class="form-control" placeholder="الاسم"
                                        name="name" value="{{ old('name') }}">
                                    @error('name')
                                        <small class="text-danger" id="basic-default-name-error" class="error">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="">صالح من <span style="color: red">*</span></label>
                                    <input type="date" name="valid_from" id="" class="form-control">
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="">صالح الى <span style="color: red">*</span></label>
                                    <input type="date" name="valid_to" class="form-control" id="">
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="">النوع</label>
                                    <select class="form-control" name="type">
                                        <option value="1">اختر البند</option>
                                        <option value="2">اشتري كمية واحصل خصم على البند</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="">الكمية المطلوبة لتطبيق العرض <span style="color: red">*</span></label>
                                    <input type="text" name="quantity" class="form-control" id="quantity">
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="">نوع الخصم </label>
                                    <select class="form-control" name="discount_type">
                                        <option value="1">خصم حقيقي</option>
                                        <option value="2">خصم نسبي</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="">قيمة الخصم <span style="color: red">*</span></label>
                                    <input type="text" name="discount_value" class="form-control" id="">
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="category">التصنيف</label>
                                        <input list="classifications" class="form-control" id="client_type" name="category"
                                            placeholder="اكتب التصنيف" value="{{ old('category') }}">
                                        <datalist id="classifications">
                                            <option value="عميل فردي">
                                            <option value="طيور لبن">
                                            <option value="أجل">
                                            <option value="طيور">
                                            <option value="السعودي والسلمي">
                                            <option value="العربية والدار البيضاء">
                                        </datalist>
                                    </div>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="">العميل </label>
                                    <select class="form-control" name="client_id">
                                        <option value=""> اختر العميل </option>
                                        @foreach ($clients as $client)
                                            <option value="{{ $client->id }}">{{ $client->trade_name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="d-flex align-items-center gap-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="is_active" value="1"
                                            checked style="width: 3rem; height: 1.5rem;">
                                        <label class="form-check-label fw-bold"
                                            style="color: #34495e; margin-right: 20px">نشط</label>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <h4 class="card-title">تفاصيل وحدات العرض</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-body row">
                                <div class="form-group col-md-6">
                                    <label for="">نوع الوحدة</label>
                                    <select class="form-control" name="unit_type">
                                        <option value="1">الكل</option>
                                        <option value="2">التصنيف</option>
                                        <option value="3">المنتجات</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="">المنتج</label>
                                    <select class="form-control" name="product_id">
                                        <option value="">NotThing Select</option>
                                        @foreach ($product as $prod)
                                            <option value="{{ $prod->id }}">{{ $prod->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="">التصنيف</label>
                                    <select class="form-control" name="category_id">
                                        <option value="">NotThing Select</option>
                                        @foreach ($category as $cat)
                                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                        @endforeach
                                    </select>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // عند تغيير حقل "نوع الوحدة"
        $('select[name="unit_type"]').change(function() {
            var selectedValue = $(this).val();
            var productField = $('select[name="product_id"]').closest('.form-group');
            var categoryField = $('select[name="category_id"]').closest('.form-group');

            productField.hide();
            categoryField.hide();

            if (selectedValue === "3") {
                productField.show();
            } else if (selectedValue === "2") {
                categoryField.show();
            } else {
                productField.hide();
                categoryField.hide();
            }
        });

        // إخفاء الحقول عند التحميل الأولي
        $('select[name="product_id"], select[name="category_id"]').closest('.form-group').hide();

        // عند تغيير حقل "النوع"
        $('select[name="type"]').change(function() {
            var selectedValue = $(this).val();
            var quantityInput = $('input[name="quantity"]');

            if (selectedValue === "") {
                quantityInput.val("0").prop("readonly", true);
            } else if (selectedValue === "discount") {
                quantityInput.val("").prop("readonly", false);
            }
        });

        // تعيين الحالة الأولية عند تحميل الصفحة
        if ($('select[name="type"]').val() === "") {
            $('input[name="quantity"]').val("0").prop("readonly", true);
        }
    });
</script>
@endsection
