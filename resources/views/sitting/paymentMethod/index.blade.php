@extends('master')

@section('content')
    <div class="content-body">


        <div class="card">

            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <div>
                        <label>الحقول التي عليها علامة <span style="color: red">*</span> الزامية</label>
                    </div>

                    <div>
                        <button type="button" class="btn btn-outline-primary" data-bs-toggle="offcanvas" data-bs-target="#addPaymentMethod">
                            <i class="fas fa-plus-circle"></i> اضافة وسيلة دفع
                        </button>
                        <button class="btn btn-outline-success">
                            <i class="fas fa-save"></i> حفظ
                        </button>

                    </div>
                </div>
            </div>
        </div>

        <x-layout.card title="">

            <div class="row">
                <div class="col-12">
                    <h4 class="fw-bold text-dark mb-4 mt-4 pb-2 border-bottom">خيارات الدفع</h4>
                </div>


                <x-payment-method-card title="تحويل بنكي" icon="fas fa-university text-primary" index="3" />
                <x-payment-method-card title="نقدي" icon="fas fa-wallet text-success" index="2" />
                <x-payment-method-card title="الدفع عند الاستلام" icon="fas fa-truck-loading text-warning" index="1" />
                <x-payment-method-card title="شيك" icon="fas fa-money-check text-info" index="3" />
                <x-payment-method-card title="PayFort" icon="fas fa-lock text-secondary" index="3" />
                <x-payment-method-card title="بيتابيس" icon="fas fa-database text-danger" index="2" />
                <x-payment-method-card title="بطاقة ائتمان" icon="fas fa-credit-card text-dark" index="3" />
                <x-payment-method-card title="الدفع يدوي" icon="fas fa-hand-holding-usd text-primary" index="3" />

                <!-- وسائل الدفع الإلكترونية -->
                <div class="col-12">
                    <h4 class="fw-bold text-dark mb-4 mt-4 pb-2 border-bottom">وسائل الدفع الإلكترونية</h4>
                </div>

                <x-payment-method-card title="PayMob" icon="fas fa-credit-card text-primary" link="https://paymob.com"
                    linkText="paymob.com" index="1" />
                <x-payment-method-card title="Authorize.Net" icon="fas fa-shield-alt text-success"
                    link="https://authorize.net" linkText="authorize.net" index="2" />
                <x-payment-method-card title="2Checkout" icon="fas fa-shopping-cart text-warning"
                    link="https://2checkout.com" linkText="2checkout.com" index="3" />
                <x-payment-method-card title="Square" icon="fas fa-border-all text-info" link="https://squareup.com"
                    linkText="squareup.com" index="4" />
                <x-payment-method-card title="Paypal Express" icon="fab fa-paypal text-primary" link="https://paypal.com"
                    linkText="paypal.com" index="5" />
                <x-payment-method-card title="Paypal Standard" icon="fab fa-paypal text-secondary" link="https://paypal.com"
                    linkText="paypal.com" index="6" />
                <x-payment-method-card title="Tamara Pay" icon="fas fa-money-bill-wave-alt text-danger"
                    link="https://api-reference.tamara.co" linkText="api-reference.tamara.co" index="7" />
                <x-payment-method-card title="Tabby" icon="fas fa-tags text-secondary" link="https://docs.tabby.ai"
                    linkText="docs.tabby.ai" index="8" />
                <x-payment-method-card title="Stripe" icon="fab fa-stripe text-info" link="https://stripe.com"
                    linkText="stripe.com" index="9" />
                <x-payment-method-card title="PayTabs Version 2" icon="fas fa-receipt text-warning"
                    link="https://paytabs.com" linkText="paytabs.com" index="10" />
                <x-payment-method-card title="Tap" icon="fas fa-mobile text-dark" link="https://tap.company"
                    linkText="tap.company" index="11" />
            </div>
        </x-layout.card>
    </div>
@endsection

@section('offcanvas')
<!-- نافذة إضافة وسيلة دفع -->
<div class="offcanvas offcanvas-start" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1" id="addPaymentMethod" aria-labelledby="addPaymentMethodLabel">
    <div class="offcanvas-header border-bottom">
        <div class="d-flex align-items-center w-100 justify-content-between">
            <h5 class="offcanvas-title mb-0" id="addPaymentMethodLabel">إضافة وسيلة دفع مخصصة</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
    </div>
    <div class="offcanvas-body">
        <form id="paymentMethodForm">
            <div class="text-center mb-4">
                <div class="avatar bg-primary-subtle rounded-circle mx-auto" style="width: 80px; height: 80px;">
                    <i class="fas fa-credit-card fa-fw text-primary fs-1 mt-3"></i>
                </div>
            </div>

            <!-- الاسم -->
            <div class="mb-3">
                <label class="form-label">الاسم</label>
                <input type="text" class="form-control" name="name">
            </div>

            <!-- التعليمات -->
            <div class="mb-3">
                <label class="form-label">التعليمات</label>
                <textarea class="form-control" name="instructions" rows="3"></textarea>
            </div>

            <!-- التفعيل للعملاء -->
            <div class="mb-3">
                <label class="form-label">التفعيل للعملاء على الانترنت</label>
                <div class="mt-2">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="activation" id="active" value="1" checked>
                        <label class="form-check-label" for="active">تم تفعيله</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="activation" id="inactive" value="0">
                        <label class="form-check-label" for="inactive">تم تعطيله</label>
                    </div>
                </div>
            </div>

            <!-- العملة الافتراضية -->
            <div class="mb-3">
                <label class="form-label">العملة الافتراضية</label>
                <select class="form-select" name="currency">
                    <option value="" selected>لا شيء</option>
                    <option value="SAR">ريال سعودي</option>
                    <option value="USD">دولار أمريكي</option>
                </select>
            </div>

            <!-- مصاريف الدفع -->
            <div class="mb-3">
                <label class="form-label">مصاريف الدفع</label>
                <div class="mt-2">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="fees" id="hasFees" value="1">
                        <label class="form-check-label" for="hasFees">حساب</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="fees" id="noFees" value="0" checked>
                        <label class="form-check-label" for="noFees">إيقاف</label>
                    </div>
                </div>
            </div>

            <!-- الحالة -->
            <div class="mb-4">
                <label class="form-label">الحالة</label>
                <div class="mt-2">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="status" id="statusActive" value="1">
                        <label class="form-check-label" for="statusActive">نشط</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="status" id="statusInactive" value="0" checked>
                        <label class="form-check-label" for="statusInactive">غير نشط</label>
                    </div>
                </div>
            </div>

            <!-- زر الحفظ -->
            <div class="d-grid">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save me-1"></i> حفظ
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const form = document.getElementById('paymentMethodForm');
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        // هنا يمكنك إضافة كود معالجة النموذج
        const offcanvas = bootstrap.Offcanvas.getInstance(document.getElementById('addPaymentMethod'));
        offcanvas.hide();
    });
</script>
@endsection
