@extends('master')

@section('title')
    سند صرف
@stop

@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">سند صرف</h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="">الرئيسيه</a>
                            </li>
                            <li class="breadcrumb-item active">اضافه
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
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <div>
                        <label>الحقول التي عليها علامة <span style="color: red">*</span> الزامية</label>
                    </div>

                    <div>
                        <a href="{{ route('expenses.index') }}" class="btn btn-outline-danger">
                            <i class="fa fa-ban"></i> الغاء
                        </a>

                        <button type="submit" form="expenses_form" class="btn btn-outline-primary"><i
                                class="fa fa-save"></i> حفظ</button>

                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <form id="expenses_form" action="{{ route('expenses.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        @php
                            $currency = $account_setting->currency ?? 'SAR';
                            $currencySymbol =
                                $currency == 'SAR' || empty($currency)
                                    ? '<img src="' .
                                        asset('assets/images/Saudi_Riyal.svg') .
                                        '" alt="ريال سعودي" width="15" style="vertical-align: middle;">'
                                    : htmlspecialchars($currency);
                        @endphp

                        <div class="form-group col-md-3">
                            <label for="amount">المبلغ <span style="color: red">*</span></label>
                            <input type="text" class="form-control form-control-lg py-3" id="amount"
                                placeholder="{{ $currencySymbol }} 0.00" name="amount" required>
                            @error('amount')
                                <span class="text-danger" id="basic-default-name-error">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="form-group col-md-3">
                            <label for="total_amount">المبلغ الإجمالي بعد الضريبة</label>
                            <input type="text" class="form-control form-control-lg py-3" id="total_amount"
                                placeholder="{{ $currencySymbol }} 0.00" name="total_amount" readonly>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="description">الوصف</label>
                            <textarea class="form-control" id="description" rows="3" name="description"></textarea>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="attachments">المرفقات</label>
                            <input type="file" name="attachments[]" id="attachments" class="d-none" multiple>
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
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="code-number">رقم الكود</label>
                            <input type="text" class="form-control" id="code-number" name="code"
                                value="{{ $code }}" readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="date">التاريخ</label>
                            <input type="date" class="form-control" id="date" name="date"
                                value="{{ date('Y-m-d') }}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="category">التصنيف</label>
                            <select id="category" class="form-control" name="expenses_category_id" required>
                                <option value="" selected disabled>-- إضافة تصنيف --</option>
                                @foreach ($expenses_categories as $expenses_category)
                                    <option value="{{ $expenses_category->id }}"
                                        {{ old('expenses_category_id') == $expenses_category->id ? 'selected' : '' }}>
                                        {{ $expenses_category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="seller">البائع</label>
                            <select id="seller" class="form-control" name="vendor_id">
                                <option value="" selected disabled>اختر بائع</option>
                                <option value="" selected disabled>اختر بائع</option>
                                <option value="" selected disabled>اختر بائع</option>

                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="warehouse">خزينة</label>
                            <input type="text" class="form-control" placeholder=" "
                                value="{{ $MainTreasury->name ?? '' }}" readonly>
                            <input type="hidden" name="treasury_id" value="{{ $MainTreasury->id ?? '' }}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="account_id">الحساب الفرعي</label>
                            <select class="form-control select2" name="account_id" id="account_id" required>
                                <option value="" selected disabled>اختر حساب</option>
                                @foreach ($accounts as $account)
                                    <option value="{{ $account->id }}">
                                        {{ $account->customer->code ?? '' }} - {{ $account->name ?? '' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="tax">الضرائب</label>
                            <button type="button" class="btn btn-info btn-block" onclick="toggleTaxFields()">إضافة
                                ضرائب</button>
                        </div>
                    </div>

                    <!-- حقول الضرائب -->
                    <div id="tax-fields" class="tax-fields" style="display: none;">
                        <span class="remove-tax" onclick="removeTaxFields()">إزالة الضرائب ×</span>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="tax1">الضريبة الأولى</label>
                                <select id="tax1" class="form-control" name="tax1">
                                    <option value="0">اختر الضريبة</option>
                                    @foreach ($taxs as $tax)
                                        <option value="{{ $tax->tax }}">{{ $tax->name ?? '' }}
                                            ({{ $tax->tax }}%)</option>
                                    @endforeach
                                </select>
                                <input type="text" class="form-control mt-2" placeholder="المبلغ" name="tax1_amount"
                                    readonly>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="tax2">الضريبة الثانية</label>
                                <select id="tax2" class="form-control" name="tax2">
                                    <option value="0">اختر الضريبة</option>
                                    @foreach ($taxs as $tax)
                                        <option value="{{ $tax->tax }}">{{ $tax->name ?? '' }}
                                            ({{ $tax->tax }}%)</option>
                                    @endforeach
                                </select>
                                <input type="text" class="form-control mt-2" placeholder="المبلغ" name="tax2_amount"
                                    readonly>
                            </div>
                        </div>
                    </div>

                    <div class="container mt-4">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-2">
                                        <label for="checkbox">مكرر</label>
                                        <input type="checkbox" id="checkbox" name="is_recurring" value="1">
                                    </div>
                                </div>
                                <div class="row" id="duplicate-options-container" style="display: none;">
                                    <div class="form-group col-md-4">
                                        <label for="duplicate-options">التكرار</label>
                                        <select id="duplicate-options" class="form-control" name="recurring_interval">
                                            <option value="" selected disabled>حدد التكرار</option>
                                            <option value="weekly">إسبوعي</option>
                                            <option value="bi-weekly">كل أسبوعين</option>
                                            <option value="monthly">شهري</option>
                                            <option value="yearly">سنوي</option>
                                            <option value="daily">يومي</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row" id="end-date-container" style="display: none;">
                                    <div class="form-group col-md-4">
                                        <label for="end-date">تاريخ الإنتهاء</label>
                                        <input type="date" class="form-control" id="end-date" name="end_date">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- زر الحفظ داخل النموذج -->
                    <div class="text-center mt-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save"></i> حفظ
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // التحكم في إظهار وإخفاء خيارات التكرار
        document.getElementById('checkbox').addEventListener('change', function() {
            var duplicateOptionsContainer = document.getElementById('duplicate-options-container');
            var endDateContainer = document.getElementById('end-date-container');
            if (this.checked) {
                duplicateOptionsContainer.style.display = 'block';
                endDateContainer.style.display = 'block';
            } else {
                duplicateOptionsContainer.style.display = 'none';
                endDateContainer.style.display = 'none';
            }
        });

        // التحكم في إظهار وإخفاء حقول الضرائب
        function toggleTaxFields() {
            $("#tax-fields").slideToggle();
        }

        function removeTaxFields() {
            $("#tax-fields").slideUp();
        }

        // حساب الضرائب والمبلغ الإجمالي
        $(document).ready(function() {
            function calculateTax() {
                let amount = parseFloat($("#amount").val()) || 0;
                let tax1Rate = parseFloat($("#tax1").val()) || 0;
                let tax2Rate = parseFloat($("#tax2").val()) || 0;

                let tax1Amount = (amount * tax1Rate) / 100;
                let tax2Amount = (amount * tax2Rate) / 100;

                $("input[name='tax1_amount']").val(tax1Amount.toFixed(2));
                $("input[name='tax2_amount']").val(tax2Amount.toFixed(2));

                let totalAmount = amount + tax1Amount + tax2Amount;
                $("#total_amount").val(totalAmount.toFixed(2));
            }

            $("#amount, #tax1, #tax2").on("input change", calculateTax);
        });
    </script>
@endsection
