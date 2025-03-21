@extends('master')

@section('title')
    اضافة مورد جديد
@stop

@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">اضافة مورد جديد </h2>
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
        <form id="clientForm" action="{{ route('SupplierManagement.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
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
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <div>
                            <label>الحقول التي عليها علامة <span style="color: red">*</span> الزامية</label>
                        </div>

                        <div>
                            <a href="{{ route('clients.index') }}" class="btn btn-outline-danger">
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

                <div class="col-md-6 col-12">

                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">بيانات العميل</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="form-body">
                                    <div class="row">
                                        <!-- الاسم التجاري -->
                                        <div class="col-12 mb-3">
                                            <div class="form-group">
                                                <label for="trade_name">الاسم التجاري <span
                                                        class="text-danger">*</span></label>
                                                <div class="position-relative has-icon-left">
                                                    <input type="text" name="trade_name" id="trade_name"
                                                        class="form-control" value="{{ old('trade_name') }}">
                                                    <div class="form-control-position">
                                                        <i class="feather icon-briefcase"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- الاسم الأول والأخير -->
                                        <div class="col-md-6 mb-3">
                                            <div class="form-group">
                                                <label for="first_name">الاسم الأول</label>
                                                <div class="position-relative has-icon-left">
                                                    <input type="text" name="first_name" id="first_name"
                                                        class="form-control" value="{{ old('first_name') }}">
                                                    <div class="form-control-position">
                                                        <i class="feather icon-user"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="form-group">
                                                <label for="last_name">الاسم الأخير</label>
                                                <div class="position-relative has-icon-left">
                                                    <input type="text" name="last_name" id="last_name"
                                                        class="form-control" value="{{ old('last_name') }}">
                                                    <div class="form-control-position">
                                                        <i class="feather icon-user"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- الهاتف والجوال -->
                                        <div class="col-md-6 mb-3">
                                            <div class="form-group">
                                                <label for="phone">الهاتف</label>
                                                <div class="position-relative has-icon-left">
                                                    <input type="text" name="phone" id="phone" class="form-control"
                                                        value="{{ old('phone') }}">
                                                    <div class="form-control-position">
                                                        <i class="feather icon-phone"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="form-group">
                                                <label for="mobile">جوال</label>
                                                <div class="position-relative has-icon-left">
                                                    <input type="text" name="mobile" id="mobile" class="form-control"
                                                        value="{{ old('mobile') }}">
                                                    <div class="form-control-position">
                                                        <i class="feather icon-smartphone"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- عنوان الشارع -->
                                        <div class="col-md-6 mb-3">
                                            <div class="form-group">
                                                <label for="street1">عنوان الشارع 1</label>
                                                <div class="position-relative has-icon-left">
                                                    <input type="text" name="street1" id="street1" class="form-control"
                                                        value="{{ old('street1') }}">
                                                    <div class="form-control-position">
                                                        <i class="feather icon-map-pin"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="form-group">
                                                <label for="street2">عنوان الشارع 2</label>
                                                <div class="position-relative has-icon-left">
                                                    <input type="text" name="street2" id="street2"
                                                        class="form-control" value="{{ old('street2') }}">
                                                    <div class="form-control-position">
                                                        <i class="feather icon-map-pin"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- المدينة والمنطقة والرمز البريدي -->
                                        <div class="col-md-4 mb-3">
                                            <div class="form-group">
                                                <label for="city">المدينة</label>
                                                <div class="position-relative has-icon-left">
                                                    <input type="text" name="city" id="city"
                                                        class="form-control" value="{{ old('city') }}">
                                                    <div class="form-control-position">
                                                        <i class="feather icon-map"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="form-group">
                                                <label for="region">المنطقة</label>
                                                <div class="position-relative has-icon-left">
                                                    <input type="text" name="region" id="region"
                                                        class="form-control" value="{{ old('region') }}">
                                                    <div class="form-control-position">
                                                        <i class="feather icon-map"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="form-group">
                                                <label for="postal_code">الرمز البريدي</label>
                                                <div class="position-relative has-icon-left">
                                                    <input type="text" name="postal_code" id="postal_code"
                                                        class="form-control" value="{{ old('postal_code') }}">
                                                    <div class="form-control-position">
                                                        <i class="feather icon-mail"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- البلد -->
                                        <div class="col-12 mb-3">
                                            <div class="form-group">
                                                <label for="country">البلد</label>
                                                <select name="country" id="country" class="form-control">
                                                    <option value="SA" {{ old('country') == 'SA' ? 'selected' : '' }}>
                                                        المملكة العربية السعودية (SA)</option>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- الرقم الضريبي والسجل التجاري -->
                                        <div class="col-md-6 mb-3">
                                            <div class="form-group">
                                                <label for="tax_number">الرقم الضريبي (اختياري)</label>
                                                <div class="position-relative has-icon-left">
                                                    <input type="text" name="tax_number" id="tax_number"
                                                        class="form-control" value="{{ old('tax_number') }}">
                                                    <div class="form-control-position">
                                                        <i class="feather icon-file-text"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="form-group">
                                                <label for="commercial_registration">سجل تجاري (اختياري)</label>
                                                <div class="position-relative has-icon-left">
                                                    <input type="text" name="commercial_registration"
                                                        id="commercial_registration" class="form-control"
                                                        value="{{ old('commercial_registration') }}">
                                                    <div class="form-control-position">
                                                        <i class="feather icon-file"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="card">
                                            <div class="card-header">
                                                <h4 class="card-title">قائمة الاتصال</h4>
                                            </div>
                                            <div class="card-content">
                                                <div class="card-body">
                                                    <div class="contact-fields-container" id="contactContainer">
                                                        <!-- الحقول الديناميكية ستضاف هنا -->
                                                    </div>
                                                    <div class="text-right mt-1">
                                                        <button type="button"
                                                            class="btn btn-outline-success mr-1 mb-1 إضافة"
                                                            onclick="addContactFields()">
                                                            <i class="feather icon-plus"></i> إضافة جهة اتصال
                                                        </button>
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
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">بيانات الحساب</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="form-body">
                                    <div class="row">
                                        <!-- رقم الكود -->
                                        <div class="col-12 mb-3">
                                            <div class="form-group">
                                                <label for="number_suply">رقم المورد</label>
                                                <div class="position-relative has-icon-left">
                                                    <input type="text" id="number_suply" class="form-control"
                                                        name="number_suply" value="{{ $nextNumber }}" readonly
                                                        style="background-color: #f8f8f8; cursor: not-allowed;">
                                                    <div class="form-control-position">
                                                        <i class="feather icon-hash"></i>
                                                    </div>
                                                </div>
                                                <small class="text-muted">يتم إنشاء الرقم تلقائياً</small>
                                            </div>
                                        </div>
                                        <!-- العملة  -->
                                        <x-form.select label="الى العملة" name="currency" id="to_currency"
                                            col="12">
                                            <option value="">العملة</option>
                                            @foreach (\App\Helpers\CurrencyHelper::getAllCurrencies() as $code => $name)
                                                <option value="{{ $code }}">{{ $code }}
                                                    {{ $name }}</option>
                                            @endforeach
                                        </x-form.select>

                                        <!-- الرصيد الافتتاحي -->
                                        <div class="col-md-6 mb-3">
                                            <div class="form-group">
                                                <label for="opening_balance">الرصيد الافتتاحي</label>
                                                <div class="position-relative has-icon-left">
                                                    <input type="number" id="opening_balance" class="form-control"
                                                        name="opening_balance" value="{{ old('opening_balance') }}">
                                                    <div class="form-control-position">
                                                        <i class="feather icon-dollar-sign"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- تاريخ الرصيد الاستحقاق -->
                                        <div class="col-md-6 mb-3">
                                            <div class="form-group">
                                                <label for="opening_balance_date">تاريخ الرصيد الاستحقاق</label>
                                                <div class="position-relative has-icon-left">
                                                    <input type="date" id="opening_balance_date" class="form-control"
                                                        name="opening_balance_date"
                                                        value="{{ old('opening_balance_date') }}">
                                                    <div class="form-control-position">
                                                        <i class="feather icon-calendar"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- العملة -->


                                        <!-- البريد الإلكتروني -->
                                        <div class="col-md-12 mb-3">
                                            <div class="form-group">
                                                <label for="email">البريد الإلكتروني</label>
                                                <div class="position-relative has-icon-left">
                                                    <input type="email" id="email" class="form-control"
                                                        name="email" value="{{ old('email') }}">
                                                    <div class="form-control-position">
                                                        <i class="feather icon-mail"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- التصنيف -->


                                        <!-- الملاحظات -->
                                        <div class="col-md-12 mb-3">
                                            <label for="notes">الملاحظات</label>
                                            <textarea class="form-control" id="notes" name="notes" rows="5" style="resize: none;">{{ old('notes') }}</textarea>
                                        </div>

                                        <!-- المرفقات -->
                                        <div class="col-md-12 mb-3">
                                            <div class="form-group">
                                                <label for="attachments">المرفقات</label>
                                                <input type="file" name="attachments" id="attachments"
                                                    class="d-none">
                                                <div class="upload-area border rounded p-3 text-center position-relative"
                                                    onclick="document.getElementById('attachments').click()">
                                                    <div class="d-flex align-items-center justify-content-center gap-2">
                                                        <i class="fas fa-cloud-upload-alt text-primary"></i>
                                                        <span class="text-primary">اضغط هنا</span>
                                                        <span>أو</span>
                                                        <span class="text-primary">اختر من جهازك</span>
                                                    </div>
                                                    <div class="position-absolute end-0 top-50 translate-middle-y me-3">
                                                        <i class="fas fa-file-alt fs-3 text-secondary"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- لغة العرض -->

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

@section('scripts')

    <script src="{{ asset('assets/js/scripts.js') }}"></script>
    <script>
        document.getElementById('clientForm').addEventListener('submit', function(e) {
            // e.preventDefault(); // احذف هذا السطر إذا كنت تريد أن يتم إرسال النموذج

            console.log('تم تقديم النموذج');

            // طباعة جميع البيانات المرسلة
            const formData = new FormData(this);
            for (let pair of formData.entries()) {
                console.log(pair[0] + ': ' + pair[1]);
            }
        });
    </script>
@endsection
