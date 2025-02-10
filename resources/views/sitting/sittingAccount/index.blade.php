@extends('master')

@section('title')
    اعدادت الحساب
@stop

@section('content')
    <x-layout.breadcrumb title="اعدادت الحساب" :items="[['title' => 'عرض']]" />

    <div class="content-body">
        <form id="clientForm" action="" method="POST" enctype="multipart/form-data">
            {{-- @csrf --}}

            <x-layout.card>
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <div>
                        <label>الحقول التي عليها علامة <span style="color: red">*</span> الزامية</label>
                    </div>
                    <div>
                        <a href="" class="btn btn-outline-warning">
                            <i class="fa fa-envelope"></i> تغيير البريد الإلكتروني
                        </a>
                        <a href="" class="btn btn-outline-secondary">
                            <i class="fa fa-key"></i> تغيير كلمة المرور
                        </a>
                        <button type="submit" class="btn btn-outline-success">
                            <i class="fa fa-save"></i> حفظ
                        </button>
                    </div>
                </div>
            </x-layout.card>

            <div class="row">
                <div class="col-md-6 col-12">
                    <x-layout.card title="بيانات العميل">
                        <div class="row">
                            <x-form.input label="الاسم التجاري" name="trade_name" icon="briefcase" required="true"
                                col="12" />

                            <x-form.input label="الاسم الأول" name="first_name" icon="user" col="6" />
                            <x-form.input label="الاسم الأخير" name="last_name" icon="user" col="6" />

                            <x-form.input label="الهاتف" name="phone" icon="phone" col="6" />
                            <x-form.input label="جوال" name="mobile" icon="smartphone" col="6" />

                            <x-form.input label="عنوان الشارع 1" name="street1" icon="map-pin" col="6" />
                            <x-form.input label="عنوان الشارع 2" name="street2" icon="map-pin" col="6" />

                            <x-form.input label="المدينة" name="city" icon="map" col="4" />
                            <x-form.input label="المنطقة" name="region" icon="map" col="4" />
                            <x-form.input label="الرمز البريدي" name="postal_code" icon="mail" col="4" />

                            <x-form.select label="البلد" name="country" icon="globe" col="12">
                                <option value="SA" selected>المملكة العربية السعودية (SA)</option>
                            </x-form.select>

                            <x-form.input label="الرقم الضريبي (اختياري)" name="tax_number" icon="file-text"
                                col="6" />
                            <x-form.input label="سجل تجاري (اختياري)" name="commercial_registration" icon="file"
                                col="6" />
                        </div>
                    </x-layout.card>
                </div>

                <div class="col-md-6">
                    <x-layout.card title="إعدادات الحساب">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <a href="{{ route('CurrencyRates.index') }}" class="text-primary">

                                        <i class="feather icon-external-link"></i> أسعار العملات

                                    </a>
                                    <x-form.select id="currency" name="currency" label="العملة" />
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <x-form.timezone-select />
                            </div>

                            <x-form.select label="تنسيقات العملات السالبة" name="negative_currency_format"
                                icon="minus-circle" col="6">
                                <option value="standard" selected>-19.5</option>
                            </x-form.select>

                            <x-form.select label="صيغة الوقت" name="date_format" icon="calendar" col="6">
                                <option value="dd/mm/yyyy" selected>dd/mm/yyyy (02/01/2025)</option>
                            </x-form.select>

                            <x-form.select label="اللغة" name="language" icon="globe" col="12">
                                <option value="ar" selected>العربية (AR)</option>
                            </x-form.select>

                            <x-form.select label="أنت تبيع" name="business_type" icon="shopping-bag" col="12">
                                <option value="products_services" selected>الخدمات والمنتجات</option>
                            </x-form.select>

                            <x-form.select label="طريقة الطباعة" name="printing_method" icon="printer" col="12">
                                <option value="browser" selected>متصفح</option>
                                <option value="pdf">PDF</option>
                            </x-form.select>
                        </div>
                    </x-layout.card>

                    <x-layout.card>
                        <x-form.file label="المرفقات" name="attachments" />
                    </x-layout.card>
                </div>
            </div>
        </form>
    </div>

    <!-- Modal أسعار العملات -->
    <div class="modal fade" id="currencyRatesModal" tabindex="-1" role="dialog"
        aria-labelledby="currencyRatesModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="currencyRatesModalLabel">أسعار العملات</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>العملة</th>
                                    <th>الرمز</th>
                                    <th>السعر مقابل الريال السعودي</th>
                                </tr>
                            </thead>
                            <tbody id="currencyRatesTableBody">
                                <!-- سيتم ملء هذا الجزء عن طريق JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/scripts.js') }}"></script>
    <script>
        document.getElementById('clientForm').addEventListener('submit', function(e) {
            // e.preventDefault();
            console.log('تم تقديم النموذج');
            const formData = new FormData(this);
            for (let pair of formData.entries()) {
                console.log(pair[0] + ': ' + pair[1]);
            }
        });
    </script>
@endsection
