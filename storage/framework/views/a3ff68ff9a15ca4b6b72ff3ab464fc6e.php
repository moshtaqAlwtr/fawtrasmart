<?php $__env->startSection('title'); ?>
    اضافة عميل
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">اضافة عميل جديد </h2>
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
        <form id="clientForm" action="<?php echo e(route('clients.store')); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>

            <!-- حقلين مخفيين لتخزين الإحداثيات -->
            <input type="hidden" name="latitude" id="latitude">
            <input type="hidden" name="longitude" id="longitude">

            <?php if($errors->any()): ?>
                <div class="alert alert-danger">
                    <ul>
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>
            <?php if(session('error')): ?>
                <div class="alert alert-danger">
                    <?php echo e(session('error')); ?>

                </div>
            <?php endif; ?>
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <div>
                            <label>الحقول التي عليها علامة <span style="color: red">*</span> الزامية</label>
                        </div>

                        <div>
                            <a href="<?php echo e(route('clients.index')); ?>" class="btn btn-outline-danger">
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
                                                        class="form-control" value="<?php echo e(old('trade_name')); ?>">
                                                    <div class="form-control-position">
                                                        <i class="feather icon-briefcase"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- الاسم الأول والأخير -->
                                        <div class="col-md-6 col-12 mb-3">
                                            <div class="form-group">
                                                <label for="first_name">الاسم الأول</label>
                                                <div class="position-relative has-icon-left">
                                                    <input type="text" name="first_name" id="first_name"
                                                        class="form-control" value="<?php echo e(old('first_name')); ?>">
                                                    <div class="form-control-position">
                                                        <i class="feather icon-user"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12 mb-3">
                                            <div class="form-group">
                                                <label for="last_name">الاسم الأخير</label>
                                                <div class="position-relative has-icon-left">
                                                    <input type="text" name="last_name" id="last_name"
                                                        class="form-control" value="<?php echo e(old('last_name')); ?>">
                                                    <div class="form-control-position">
                                                        <i class="feather icon-user"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- الهاتف والجوال -->
                                        <div class="col-md-6 col-12 mb-3">
                                            <div class="form-group">
                                                <label for="phone">الهاتف</label>
                                                <div class="position-relative has-icon-left">
                                                    <input type="text" name="phone" id="phone" class="form-control"
                                                        value="<?php echo e(old('phone')); ?>">
                                                    <div class="form-control-position">
                                                        <i class="feather icon-phone"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12 mb-3">
                                            <div class="form-group">
                                                <label for="mobile">جوال</label>
                                                <div class="position-relative has-icon-left">
                                                    <input type="text" name="mobile" id="mobile" class="form-control"
                                                        value="<?php echo e(old('mobile')); ?>">
                                                    <div class="form-control-position">
                                                        <i class="feather icon-smartphone"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- عنوان الشارع -->
                                        <div class="col-md-6 col-12 mb-3">
                                            <div class="form-group">
                                                <label for="street1">الشارع </label>
                                                <div class="position-relative has-icon-left">
                                                    <input type="text" name="street1" id="street1"
                                                        class="form-control" value="<?php echo e(old('street1')); ?>">
                                                    <div class="form-control-position">
                                                        <i class="feather icon-map-pin"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12 mb-3">
                                            <div class="form-group">
                                                <label for="street2">الحي</label>
                                                <div class="position-relative has-icon-left">
                                                    <input type="text" name="street2" id="street2"
                                                        class="form-control" value="<?php echo e(old('street2')); ?>">
                                                    <div class="form-control-position">
                                                        <i class="feather icon-map-pin"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- المدينة والمنطقة والرمز البريدي -->
                                        <div class="col-md-4 col-12 mb-3">
                                            <div class="form-group">
                                                <label for="city">المدينة</label>
                                                <div class="position-relative has-icon-left">
                                                    <input type="text" name="city" id="city"
                                                        class="form-control" value="<?php echo e(old('city')); ?>">
                                                    <div class="form-control-position">
                                                        <i class="feather icon-map"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-12 mb-3">
                                            <div class="form-group">
                                                <label for="region">المنطقة</label>
                                                <div class="position-relative has-icon-left">
                                                    <input type="text" name="region" id="region"
                                                        class="form-control" value="<?php echo e(old('region')); ?>">
                                                    <div class="form-control-position">
                                                        <i class="feather icon-map"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-12 mb-3">
                                            <div class="form-group">
                                                <label for="postal_code">الرمز البريدي</label>
                                                <div class="position-relative has-icon-left">
                                                    <input type="text" name="postal_code" id="postal_code"
                                                        class="form-control" value="<?php echo e(old('postal_code')); ?>">
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
                                                <input type="text" name="country" id="country" class="form-control"
                                                    value="<?php echo e(old('country')); ?>">
                                            </div>
                                        </div>

                                        <!-- الرقم الضريبي والسجل التجاري -->
                                        <div class="col-md-6 col-12 mb-3">
                                            <div class="form-group">
                                                <label for="tax_number">الرقم الضريبي (اختياري)</label>
                                                <div class="position-relative has-icon-left">
                                                    <input type="text" name="tax_number" id="tax_number"
                                                        class="form-control" value="<?php echo e(old('tax_number')); ?>">
                                                    <div class="form-control-position">
                                                        <i class="feather icon-file-text"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12 mb-3">
                                            <div class="form-group">
                                                <label for="commercial_registration">سجل تجاري (اختياري)</label>
                                                <div class="position-relative has-icon-left">
                                                    <input type="text" name="commercial_registration"
                                                        id="commercial_registration" class="form-control"
                                                        value="<?php echo e(old('commercial_registration')); ?>">
                                                    <div class="form-control-position">
                                                        <i class="feather icon-file"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- الحد الائتماني والمدة الائتمانية -->
                                        <?php $__currentLoopData = $GeneralClientSettings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $GeneralClientSetting): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if($GeneralClientSetting->is_active): ?>
                                                <?php if($GeneralClientSetting->key == 'credit_limit'): ?>
                                                    <div class="col-md-6 col-12 mb-3">
                                                        <div class="form-group">
                                                            <label for="credit_limit">الحد الائتماني</label>
                                                            <div class="position-relative has-icon-left">
                                                                <input type="number" name="credit_limit"
                                                                    id="credit_limit" class="form-control"
                                                                    value="<?php echo e(old('credit_limit', 0)); ?>">
                                                                <div class="form-control-position">
                                                                    <span>SAR</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                        <?php $__currentLoopData = $GeneralClientSettings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $GeneralClientSetting): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if($GeneralClientSetting->is_active): ?>
                                                <?php if($GeneralClientSetting->key == 'credit_duration'): ?>
                                                    <div class="col-md-6 col-12 mb-3">
                                                        <div class="form-group">
                                                            <label for="credit_period">المدة الائتمانية</label>
                                                            <div class="position-relative has-icon-left">
                                                                <input type="number" name="credit_period"
                                                                    id="credit_period" class="form-control"
                                                                    value="<?php echo e(old('credit_period', 0)); ?>">
                                                                <div class="form-control-position">
                                                                    <span>أيام</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <!-- زر إظهار الخريطة -->
                                        <?php $__currentLoopData = $GeneralClientSettings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $GeneralClientSetting): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if($GeneralClientSetting->is_active): ?>
                                                <?php if($GeneralClientSetting->key == 'location'): ?>
                                                    <div class="col-12 mb-3">
                                                        <button type="button" class="btn btn-outline-primary mb-2"
                                                            onclick="requestLocationPermission()">
                                                            <i class="feather icon-map"></i> إظهار الخريطة
                                                        </button>
                                                        <div id="map-container" style="display: none;">
                                                            <div id="map" style="height: 400px; width: 100%;"></div>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                <div class="col-md-6 col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">بيانات الحساب</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="form-body">
                                    <div class="row">
                                        <!-- رقم الكود -->
                                        <div class="col-6 mb-3">
                                            <div class="form-group">
                                                <label for="code">رقم الكود <span class="text-danger">*</span></label>
                                                <div class="position-relative has-icon-left">
                                                    <input type="text" id="code" class="form-control"
                                                        name="code" value="<?php echo e(old('code', $newCode)); ?>" readonly>
                                                    <div class="form-control-position">
                                                        <i class="feather icon-hash"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <!-- طريقة الفاتورة -->
                                        <div class="col-md-6 col-12 mb-3">
                                            <div class="form-group">
                                                <label for="printing_method">طريقة الفاتورة</label>
                                                <div class="position-relative has-icon-left">
                                                    <select class="form-control" id="printing_method"
                                                        name="printing_method">
                                                        <option value="1"
                                                            <?php echo e(old('printing_method') == 1 ? 'selected' : ''); ?>>الطباعة
                                                        </option>
                                                        <option value="2"
                                                            <?php echo e(old('printing_method') == 2 ? 'selected' : ''); ?>>ارسل عبر
                                                            البريد</option>
                                                    </select>
                                                    <div class="form-control-position">
                                                        <i class="feather icon-file-text"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- الرصيد الافتتاحي -->
                                        <?php $__currentLoopData = $GeneralClientSettings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $GeneralClientSetting): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if($GeneralClientSetting->is_active): ?>
                                                <?php if($GeneralClientSetting->key == 'opening_balance'): ?>
                                                    <div class="col-md-6 col-12 mb-3">
                                                        <div class="form-group">
                                                            <label for="opening_balance">الرصيد الافتتاحي</label>
                                                            <div class="position-relative has-icon-left">
                                                                <input type="number" id="opening_balance"
                                                                    class="form-control" name="opening_balance"
                                                                    value="<?php echo e(old('opening_balance')); ?>">
                                                                <div class="form-control-position">
                                                                    <i class="feather icon-dollar-sign"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <!-- تاريخ الرصيد الاستحقاق -->
                                        <div class="col-md-6 col-12 mb-3">
                                            <div class="form-group">
                                                <label for="opening_balance_date">تاريخ الرصيد الاستحقاق</label>
                                                <div class="position-relative has-icon-left">
                                                    <input type="date" id="opening_balance_date" class="form-control"
                                                        name="opening_balance_date"
                                                        value="<?php echo e(old('opening_balance_date', date('Y-m-d'))); ?>">
                                                    <div class="form-control-position">
                                                        <i class="feather icon-calendar"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- العملة -->
                                        <div class="col-md-12 col-12 mb-3">
                                            <div class="form-group">
                                                <label for="currency">العملة</label>
                                                <div class="position-relative has-icon-left">
                                                    <select class="form-control" id="currency" name="currency">
                                                        <option value="SAR"
                                                            <?php echo e(old('currency') == 'SAR' ? 'selected' : ''); ?>>SAR</option>
                                                        <option value="USD"
                                                            <?php echo e(old('currency') == 'USD' ? 'selected' : ''); ?>>USD</option>
                                                        <option value="EUR"
                                                            <?php echo e(old('currency') == 'EUR' ? 'selected' : ''); ?>>EUR</option>
                                                    </select>
                                                    <div class="form-control-position">
                                                        <i class="feather icon-credit-card"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- البريد الإلكتروني -->
                                        <div class="col-md-12 col-12 mb-3">
                                            <div class="form-group">
                                                <label for="email">البريد الإلكتروني</label>
                                                <div class="position-relative has-icon-left">
                                                    <input type="email" id="email" class="form-control"
                                                        name="email" value="<?php echo e(old('email')); ?>">
                                                    <div class="form-control-position">
                                                        <i class="feather icon-mail"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- التصنيف -->
                                        <div class="col-md-12 col-12 mb-3">
                                            <div class="form-group">
                                                <label for="category">التصنيف</label>
                                                <input list="classifications" class="form-control" id="client_type"
                                                    name="category" placeholder="اكتب التصنيف" value="">
                                                <datalist id="classifications" name="classification_id">
                                                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($category->name); ?>">
                                                            <!-- هنا نعرض الـ name فقط -->
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </datalist>
                                            </div>
                                        </div>

                                        <!-- الملاحظات -->
                                        <div class="col-md-12 col-12 mb-3">
                                            <label for="notes">الملاحظات</label>
                                            <textarea class="form-control" id="notes" name="notes" rows="5" style="resize: none;"><?php echo e(old('notes')); ?></textarea>
                                        </div>

                                        <!-- المرفقات -->
                                        <?php $__currentLoopData = $GeneralClientSettings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $GeneralClientSetting): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if($GeneralClientSetting->is_active): ?>
                                                <?php if($GeneralClientSetting->key == 'image'): ?>
                                                    <div class="col-md-12 col-12 mb-3">
                                                        <div class="form-group">
                                                            <label for="attachments">المرفقات</label>
                                                            <input type="file" name="attachments" id="attachments"
                                                                class="d-none">
                                                            <div class="upload-area border rounded p-3 text-center position-relative"
                                                                onclick="document.getElementById('attachments').click()">
                                                                <div
                                                                    class="d-flex align-items-center justify-content-center gap-2">
                                                                    <i class="fas fa-cloud-upload-alt text-primary"></i>
                                                                    <span class="text-primary">اضغط هنا</span>
                                                                    <span>أو</span>
                                                                    <span class="text-primary">اختر من جهازك</span>
                                                                </div>
                                                                <div
                                                                    class="position-absolute end-0 top-50 translate-middle-y me-3">
                                                                    <i class="fas fa-file-alt fs-3 text-secondary"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 col-12">
                                                            <div class="form-group">
                                                                <label for="language">نوع العميل </label>
                                                                <div class="position-relative has-icon-left">
                                                                    <select class="form-control" name="client_type"
                                                                        id="client_type">
                                                                        <option value="1"
                                                                            <?php echo e(old('client_type') == 1 ? 'selected' : ''); ?>>
                                                                            عميل VIP
                                                                        </option>
                                                                        <option value="2"
                                                                            <?php echo e(old('client_type') == 2 ? 'selected' : ''); ?>>
                                                                            عميل عادي
                                                                            عادي</option>


                                                                    </select>
                                                                    <div class="form-control-position">

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12 col-12 mb-3">
                                                            <div class="form-group">
                                                                <label for="employee_id" class="form-label">الموظف
                                                                    المسؤول</label>
                                                                <select name="employee_id" id="employee_id"
                                                                    class="form-control <?php $__errorArgs = ['employee_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                                                    <option value="">اختر الموظف</option>
                                                                    <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <option value="<?php echo e($employee->id); ?>">
                                                                            <?php echo e($employee->full_name); ?>

                                                                        </option>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                </select>
                                                                <?php $__errorArgs = ['employee_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                            </div>
                                                        </div>

                                                    </div>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script src="<?php echo e(asset('assets/js/scripts.js')); ?>"></script>
    <!-- إضافة مكتبة Google Maps -->
    <script src="https://maps.googleapis.com/maps/api/js?key=<?php echo e(env('GOOGLE_MAPS_API_KEY')); ?>&libraries=places"></script>
    <script>
        // دالة لعرض الخريطة
        function toggleMap() {
            const mapContainer = document.getElementById('map-container');
            if (mapContainer.style.display === 'none') {
                mapContainer.style.display = 'block';
            } else {
                mapContainer.style.display = 'none';
            }
        }

        // دالة لطلب الإذن من المستخدم للوصول إلى موقعه الحالي
        function requestLocationPermission() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        // إذا وافق المستخدم، نعرض الخريطة
                        toggleMap();
                        initMap(position.coords.latitude, position.coords.longitude);
                    },
                    (error) => {
                        // إذا رفض المستخدم أو حدث خطأ
                        alert('⚠️ يرجى السماح بالوصول إلى الموقع لعرض الخريطة.');
                        console.error('Error getting location:', error);
                    }
                );
            } else {
                // إذا كان المتصفح لا يدعم الـ Geolocation
                alert('⚠️ المتصفح لا يدعم تحديد الموقع. يرجى استخدام متصفح آخر.');
            }
        }

        // دالة لتهيئة الخريطة
        function initMap(lat, lng) {
            // تعيين الإحداثيات في الحقول المخفية
            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lng;

            // تهيئة الخريطة مع الإحداثيات المحددة
            const map = new google.maps.Map(document.getElementById('map'), {
                center: {
                    lat,
                    lng
                },
                zoom: 15, // زيادة مستوى التكبير لدقة أعلى
            });

            // إضافة علامة (Marker) في الموقع المحدد
            const marker = new google.maps.Marker({
                position: {
                    lat,
                    lng
                },
                map: map,
                draggable: true, // السماح بسحب العلامة
                title: 'موقعك الحالي',
            });

            // تحديث الحقول المخفية عند تحريك العلامة
            google.maps.event.addListener(marker, 'dragend', function() {
                const newLat = marker.getPosition().lat();
                const newLng = marker.getPosition().lng();
                document.getElementById('latitude').value = newLat;
                document.getElementById('longitude').value = newLng;

                // جلب العنوان بناءً على الإحداثيات الجديدة
                fetchAddressFromCoordinates(newLat, newLng);
            });

            // جلب العنوان عند النقر على الخريطة
            google.maps.event.addListener(map, 'click', function(event) {
                const newLat = event.latLng.lat();
                const newLng = event.latLng.lng();
                marker.setPosition({
                    lat: newLat,
                    lng: newLng
                });
                document.getElementById('latitude').value = newLat;
                document.getElementById('longitude').value = newLng;

                // جلب العنوان بناءً على الإحداثيات الجديدة
                fetchAddressFromCoordinates(newLat, newLng);
            });
        }

        // دالة لجلب العنوان من الإحداثيات
        function fetchAddressFromCoordinates(lat, lng) {
            const geocoder = new google.maps.Geocoder();
            const latLng = {
                lat,
                lng
            };

            geocoder.geocode({
                location: latLng
            }, (results, status) => {
                if (status === 'OK') {
                    if (results[0]) {
                        const addressComponents = results[0].address_components;

                        // تعبئة الحقول بناءً على البيانات المسترجعة
                        document.getElementById('country').value = getAddressComponent(addressComponents,
                            'country');
                        document.getElementById('region').value = getAddressComponent(addressComponents,
                            'administrative_area_level_1');
                        document.getElementById('city').value = getAddressComponent(addressComponents,
                            'locality') || getAddressComponent(addressComponents, 'administrative_area_level_2');
                        document.getElementById('postal_code').value = getAddressComponent(addressComponents,
                            'postal_code');
                        document.getElementById('street1').value = getAddressComponent(addressComponents, 'route');
                        document.getElementById('street2').value =
                            getAddressComponent(addressComponents, 'neighborhood') ||
                            getAddressComponent(addressComponents, 'sublocality') ||
                            getAddressComponent(addressComponents, 'sublocality_level_1');
                    } else {
                        console.error('لم يتم العثور على عنوان لهذه الإحداثيات.');
                    }
                } else {
                    console.error('حدث خطأ أثناء جلب العنوان:', status);
                }
            });
        }

        // دالة مساعدة لاستخراج مكونات العنوان
        function getAddressComponent(addressComponents, type) {
            const component = addressComponents.find(component => component.types.includes(type));
            return component ? component.long_name : '';
        }

        // التأكد من وجود الإحداثيات قبل الإرسال
        document.getElementById('clientForm').addEventListener('submit', function(e) {
            const lat = document.getElementById('latitude').value;
            const lon = document.getElementById('longitude').value;

            if (!lat || !lon) {
                e.preventDefault();
                alert('⚠️ يرجى تحديد الموقع من الخريطة قبل الإرسال!');
            }
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\fawtramsmart\fawtra\resources\views/client/create.blade.php ENDPATH**/ ?>