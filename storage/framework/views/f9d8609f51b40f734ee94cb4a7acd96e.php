<?php $__env->startSection('content'); ?>
<style>
    .client-item {
        transition: background-color 0.3s ease;
    }
    
    .client-item:hover {
        background-color: #f8f9fa; /* لون فاتح عند تمرير الماوس */
    }
    
    .client-item.selected {
        background-color: #cce5ff; /* لون أزرق فاتح عند التحديد */
        border-left: 4px solid #007bff; /* شريط جانبي أزرق */
    }
</style>

<div class="container-fluid">
    <div class="row g-0">
        <!-- القائمة الجانبية للعملاء -->
        <div class="col-md-4 border-end vh-100 overflow-hidden">
            <div class="d-flex flex-column h-100">
                <!-- شريط البحث -->
                <div class="search-bar p-3 border-bottom bg-white sticky-top">
                    <div class="d-flex gap-2 mb-2">
                        <button class="btn btn-light border" type="button">
                            <i class="fas fa-bars"></i>
                        </button>
                        <div class="input-group">
                            <input type="text" class="form-control border-end-0" id="searchInput"
                                placeholder="البحث عن عميل بالاسم او البريد او الكود او رقم الهاتف..."> 
                            <span class="input-group-text bg-white border-start-0">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                            
                        </div>
                        <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#addCustomerModal">
                            <i class="fas fa-plus"></i>
                        </button>
                       
                    </div>
                   
                     
                    <!-- Advanced Search Options -->
                    <div class="collapse" id="advancedSearch">
                        <div class="card card-body p-3 border-0">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="checkMerf">
                                        <label class="form-check-label" for="checkMerf">المعرف</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="checkStatus">
                                        <label class="form-check-label" for="checkStatus">الحالة</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="checkCountry">
                                        <label class="form-check-label" for="checkCountry">رمز البلد</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="checkEmail">
                                        <label class="form-check-label" for="checkEmail">البريد الإلكتروني</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="checkPhone">
                                        <label class="form-check-label" for="checkPhone">رقم الهاتف</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="checkCode">
                                        <label class="form-check-label" for="checkCode">كود العميل</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="checkLink">
                                        <label class="form-check-label" for="checkLink">الرابط</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="checkTradeName">
                                        <label class="form-check-label" for="checkTradeName">الاسم التجاري</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="checkClientStatus">
                                        <label class="form-check-label" for="checkClientStatus">حالات متابعة العميل</label>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3">
                                <div class="d-flex justify-content-between">
                                    <button class="btn btn-sm btn-primary" type="button">بحث</button>
                                    <button class="btn btn-sm btn-secondary" type="button">إعادة البحث</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- قائمة العملاء -->
                <div id="clientsList" class="mt-3">
                <div class="clients-list overflow-auto flex-grow-1">
                    <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="client-item p-3 border-bottom hover-bg-light cursor-pointer"
     data-client-id="<?php echo e($client->id); ?>"
     onclick="selectClient(<?php echo e($client->id); ?>)">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="badge bg-success country-badge">
                                        <?php echo e($client->country_code ?? 'SA'); ?>

                                    </span>
                                    <span class="client-number text-muted">#<?php echo e($client->code); ?></span>
                                    <span class="client-name text-primary fw-medium"><?php echo e($client->trade_name); ?></span>
                                </div>
                                <div class="client-info small text-muted mt-1">
                                    <i class="far fa-clock me-1"></i>
                                    <?php echo e($client->created_at->format('H:i')); ?> |
                                    <?php echo e($client->created_at->format('M d,Y')); ?>

                                </div>
                                <?php if($client->phone): ?>
                                <div class="client-contact small text-muted mt-1">
                                    <i class="fas fa-phone-alt me-1"></i>
                                    <?php echo e($client->phone); ?>

                                </div>
                                <?php endif; ?>
                            </div>
                            <div class="status-badge px-2 py-1 rounded 
                          <?php if(optional($client->latestStatus)->status == 'مديون'): ?> 
    bg-warning
<?php elseif(optional($client->latestStatus)->status == 'دائن'): ?> 
    bg-danger
<?php elseif(optional($client->latestStatus)->status == 'مميز'): ?> 
    bg-primary
<?php else: ?> 
    bg-secondary
<?php endif; ?> text-white">
<?php echo e(optional($client->latestStatus)->status ?? 'غير محدد'); ?>


                        </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
    </div>
        <!-- تفاصيل العميل -->
        <div class="col-md-8 bg-light">
            <div class="client-details h-100">
                <div class="card border-0 h-100">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3 border-0">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-outline-primary btn-sm" id="prevButton" onclick="loadPreviousClient()">
                                <i class="fas fa-chevron-right"></i> السابق
                            </button>
                            <button type="button" class="btn btn-outline-primary btn-sm" id="nextButton" onclick="loadNextClient()">
                                التالي <i class="fas fa-chevron-left"></i>
                            </button>
                        </div>
                        
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="printClientDetails()">
                                <i class="fas fa-print"></i>
                            </button>
                            <a href="#" id="editClientButton" class="btn btn-outline-primary btn-sm disabled">
                                <i class="fas fa-edit"></i>
                            </a>
                            
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row g-3">
                            <!-- معلومات العميل -->



                        </div>

                        <!-- Tabs -->
                        <ul class="nav nav-tabs mt-4" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="details-tab" data-bs-toggle="tab" href="#details" role="tab">
                                    <i class="fas fa-clipboard-list me-1"></i>
                                    المتابعة
                                    <span id="notes-count-badge" class="badge bg-primary rounded-pill ms-1"><?php echo e($ClientRelations->count()); ?></span>
                                </a>
                            </li>
                            
                            
                        </ul>

                        <div class="tab-content mt-3">
                            <!-- تبويب المتابعة -->
                            <div class="tab-pane fade show active" id="details" role="tabpanel">
                            
                                <!-- نموذج إضافة ملاحظة -->
                                <form id="clientForm" action="<?php echo e(route('clients.addnotes')); ?>" method="POST" enctype="multipart/form-data">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="client_id" id="client_id">
                                    <div class="card shadow-sm">
                                        <div class="card-body">
                                            <h6 class="card-title mb-3">إضافة ملاحظة جديدة</h6>
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <select class="form-select" name="status" required>
                                                        <option value="">اختر الحالة</option>
                                                        <option class="btn btn-warning" value="مديون">مديون</option>
                                                        <option class="btn btn-danger" value="دائن">دائن</option>
                                                        <option class="btn btn-primary" value="مميز">مميز</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <select class="form-select" name="process" required>
                                                        <option value="">اختر الإجراء</option>
                                                        <option value="متابعة هاتفية">متابعة هاتفية</option>
                                                        <option value="تحصيل">تحصيل</option>
                                                        <option value="توصيل">توصيل</option>
                                                        <option value="حجز">حجز</option>
                                                    </select>
                                                </div>
                                                <div class="col-12">
                                                    <textarea class="form-control" name="description" rows="4"
                                                              placeholder="اكتب ملاحظتك هنا..." required></textarea>
                                                </div>
                                                <div class="col-12 text-end">
                                                    <button type="submit" class="btn btn-primary">
                                                        <i class="fas fa-save me-1"></i>
                                                        حفظ الملاحظة
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <div id="notesTimeline">  
                                <div class="notes-timeline">
                                    <?php $__currentLoopData = $ClientRelations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ClientRelation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                   
                                                  
                           
                                   <div class="note-item mb-3">
    <div class="d-flex align-items-center text-muted small mb-1">
        <i class="far fa-clock me-1"></i> <?php echo e($ClientRelation->created_at); ?>

        <span class="mx-2">•</span>
        
        <i class="far fa-user me-1"></i> <?php echo e($ClientRelation->process); ?>

        <span class="mx-2">•</span>

        <i class="fas fa-info-circle me-1"></i> 
        <span class="badge 
            <?php if($ClientRelation->status == 'مميز'): ?> bg-primary
            <?php elseif($ClientRelation->status == 'مديون'): ?> bg-warning text-dark
            <?php elseif($ClientRelation->status == 'دائن'): ?> bg-danger
            <?php else: ?> bg-secondary <?php endif; ?>">
            <?php echo e($ClientRelation->status); ?>

        </span>
    </div>
                                   </div>

    <div class="note-content p-3 bg-white rounded shadow-sm">
        <i class="far fa-comment-dots text-muted me-1"></i> <?php echo e($ClientRelation->description); ?>

    </div>
</div>

                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>

                            <!-- تبويب النقاط والأرصدة -->
                            <div class="tab-pane fade" id="balance" role="tabpanel">
                                <div class="text-end mb-3">
                                    
                                    <a href="<?php echo e(route('MangRechargeBalances.create')); ?>" type="button" class="btn btn-primary btn-sm">
                                        <i class="fas fa-plus me-1"></i>
                                        إضافة رصيد
                                    </a>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="text-center py-5 text-muted">
                                            <i class="fas fa-wallet fa-3x mb-3"></i>
                                            <p>لا توجد أرصدة مضافة حتى الآن</p>
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
<div class="modal fade" id="addCustomerModal" tabindex="-1" aria-labelledby="addCustomerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCustomerModalLabel">إضافة عميل جديد</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="إغلاق">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
          
            <div class="row">

                <div class="col-md-6 col-12">
                    <form id="clientForm" action="<?php echo e(route('clients.mang_client_store')); ?>" method="POST" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
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
                                        <div class="col-md-6 mb-3">
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
                                        <div class="col-md-6 mb-3">
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
                                        <div class="col-md-6 mb-3">
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
                                        <div class="col-md-6 mb-3">
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
                                        <div class="col-md-6 mb-3">
                                            <div class="form-group">
                                                <label for="street1">عنوان الشارع 1</label>
                                                <div class="position-relative has-icon-left">
                                                    <input type="text" name="street1" id="street1" class="form-control"
                                                        value="<?php echo e(old('street1')); ?>">
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
                                                        class="form-control" value="<?php echo e(old('street2')); ?>">
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
                                                        class="form-control" value="<?php echo e(old('city')); ?>">
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
                                                        class="form-control" value="<?php echo e(old('region')); ?>">
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
                                                <select name="country" id="country" class="form-control">
                                                    <option value="SA" <?php echo e(old('country') == 'SA' ? 'selected' : ''); ?>>
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
                                                        class="form-control" value="<?php echo e(old('tax_number')); ?>">
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
                                                        value="<?php echo e(old('commercial_registration')); ?>">
                                                    <div class="form-control-position">
                                                        <i class="feather icon-file"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- الحد الائتماني والمدة الائتمانية -->
                                        <div class="col-md-6 mb-3">
                                            <div class="form-group">
                                                <label for="credit_limit">الحد الائتماني</label>
                                                <div class="position-relative has-icon-left">
                                                    <input type="number" name="credit_limit" id="credit_limit"
                                                        class="form-control" value="<?php echo e(old('credit_limit', 0)); ?>">
                                                    <div class="form-control-position">
                                                        <span>SAR</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="form-group">
                                                <label for="credit_period">المدة الائتمانية</label>
                                                <div class="position-relative has-icon-left">
                                                    <input type="number" name="credit_period" id="credit_period"
                                                        class="form-control" value="<?php echo e(old('credit_period', 0)); ?>">
                                                    <div class="form-control-position">
                                                        <span>أيام</span>
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
                                        <div class="col-md-6 mb-3">
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
                                        <div class="col-md-6 mb-3">
                                            <div class="form-group">
                                                <label for="opening_balance">الرصيد الافتتاحي</label>
                                                <div class="position-relative has-icon-left">
                                                    <input type="number" id="opening_balance" class="form-control"
                                                        name="opening_balance" value="<?php echo e(old('opening_balance')); ?>">
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
                                                        value="<?php echo e(old('opening_balance_date', date('Y-m-d'))); ?>">
                                                    <div class="form-control-position">
                                                        <i class="feather icon-calendar"></i>
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
                                        <div class="col-md-12 mb-3">
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
                                        <div class="col-md-12 mb-3">
                                            <div class="form-group">
                                                <label for="category">التصنيف</label>
                                                <input list="classifications" class="form-control" id="client_type"
                                                    name="category" placeholder="اكتب التصنيف"
                                                    value="<?php echo e(old('category')); ?>">
                                                <datalist id="classifications">
                                                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($category->id); ?>"><?php echo e($category->name); ?>

                                                        </option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </datalist>
                                            </div>
                                        </div>

                                        <!-- الملاحظات -->
                                        <div class="col-md-12 mb-3">
                                            <label for="notes">الملاحظات</label>
                                            <textarea class="form-control" id="notes" name="notes" rows="5" style="resize: none;"><?php echo e(old('notes')); ?></textarea>
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
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="language">نوع العميل </label>
                                                    <div class="position-relative has-icon-left">
                                                        <select class="form-control" name="client_type" id="client_type">
                                                            <option value="1"
                                                                <?php echo e(old('client_type') == 1 ? 'selected' : ''); ?>>عميل VIP
                                                            </option>
                                                            <option value="2"
                                                                <?php echo e(old('client_type') == 2 ? 'selected' : ''); ?>>عميل عادي
                                                                عادي</option>
                                                            

                                                        </select>
                                                        <div class="form-control-position">

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12 mb-3">
                                                <div class="form-group">
                                                    <label for="employee_id" class="form-label">الموظف المسؤول</label>
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

                                        <!-- لغة العرض -->

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
                <button type="submit" class="btn btn-primary" onclick="saveCustomer()">حفظ</button>
            </div>
        </form>
        </div>
    </div>
</div>
<script>
let clientsList = []; // قائمة العملاء
let currentIndex = 0; // مؤشر العميل الحالي

// تحميل قائمة العملاء عند بدء الصفحة
document.addEventListener("DOMContentLoaded", function () {
    fetch("/clients/list") // تأكد من صحة الرابط
        .then(response => response.json())
        .then(data => {
            clientsList = data;
            if (clientsList.length > 0) {
                selectClient(clientsList[currentIndex].id);
            }
        })
        .catch(error => console.error("❌ خطأ أثناء تحميل قائمة العملاء:", error));
});

// تحميل العميل التالي
function loadNextClient() {
    if (currentIndex < clientsList.length - 1) {
        currentIndex++;
        selectClient(clientsList[currentIndex].id); // تأكد من أن هذه الدالة موجودة لديك
    }
}

// تحميل العميل السابق
function loadPreviousClient() {
    if (currentIndex > 0) {
        currentIndex--;
        selectClient(clientsList[currentIndex].id); // تأكد من أن هذه الدالة موجودة لديك
    }
}

// عند تحديد عميل، تحديث المعلومات
function selectClient(clientId) {
    document.getElementById("client_id").value = clientId;

    document.querySelectorAll(".client-item").forEach(item => {
        item.classList.remove("selected", "bg-light");
    });
    document.querySelector(`[data-client-id="${clientId}"]`)?.classList.add("selected", "bg-light");

    fetch(`/clients/clients_management/clients/${clientId}/notes`)
        .then(response => response.json())
        .then(data => {
            let notesContainer = document.querySelector(".notes-timeline");
            let notesCountBadge = document.querySelector("#notes-count-badge");
            notesContainer.innerHTML = "";

            if (data.message) {
                notesContainer.innerHTML = `<p class="text-muted">${data.message}</p>`;
                notesCountBadge.textContent = "0";
            } else {
                notesCountBadge.textContent = data.length;

                data.forEach(note => {
                    let formattedDate = new Date(note.created_at).toLocaleString("ar-EG", {
                        year: "numeric",
                        month: "2-digit",
                        day: "2-digit",
                        hour: "2-digit",
                        minute: "2-digit",
                        second: "2-digit",
                        hour12: false
                    });

                    let statusClass = "bg-secondary";
                    if (note.status === "مميز") statusClass = "bg-primary";
                    else if (note.status === "مديون") statusClass = "bg-warning text-dark";
                    else if (note.status === "دائن") statusClass = "bg-danger";

                    notesContainer.innerHTML += `
                        <div class="note-item mb-3 border rounded p-2">
                            <div class="d-flex align-items-center text-muted small mb-1">
                                <i class="far fa-calendar-alt me-1 text-primary"></i> ${formattedDate}
                                <span class="mx-2">•</span>
                                <i class="fas fa-bell me-1 text-info"></i> ${note.process}
                                <span class="mx-2">•</span>
                                <i class="fas fa-info-circle me-1"></i>
                                <span class="badge ${statusClass}">${note.status}</span>
                            </div>
                            <div class="note-content p-3 bg-white rounded shadow-sm">
                                <i class="far fa-comment-dots text-muted me-1"></i> ${note.description}
                            </div>
                        </div>
                    `;
                });
            }
        })
        .catch(error => console.error("❌ خطأ أثناء تحميل الملاحظات:", error));
}

</script>

<script>
let searchTimeout;

document.getElementById("searchInput").addEventListener("input", function () {
    let searchValue = this.value.trim();
    let clientsListContainer = document.getElementById("clientsList");

    if (searchValue.length > 0) {
        // إذا كان هناك نص في حقل البحث، قم بالبحث
        fetch(`/clients/clients_management/clients/search?query=${encodeURIComponent(searchValue)}`)
            .then(response => response.json())
            .then(data => {
                clientsListContainer.innerHTML = "";

                if (data.length === 0) {
                    clientsListContainer.innerHTML = `<p class="text-muted">لا توجد نتائج مطابقة</p>`;
                } else {
                    data.forEach(client => {
                        let status = client.latest_status ? client.latest_status.status : 'غير محدد';
                        let statusColor = getStatusColor(status);

                        clientsListContainer.innerHTML += `
                            <div class="client-item p-3 border-bottom hover-bg-light cursor-pointer" data-client-id="${client.id}" onclick="selectClient(${client.id})">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="badge bg-success country-badge">
                                                ${client.country_code || 'SA'}
                                            </span>
                                            <span class="client-number text-muted">#${client.code}</span>
                                            <span class="client-name text-primary fw-medium">${client.trade_name}</span>
                                        </div>
                                        <div class="client-info small text-muted mt-1">
                                            <i class="far fa-clock me-1"></i>
                                            ${new Date(client.created_at).toLocaleTimeString()} |
                                            ${new Date(client.created_at).toLocaleDateString()}
                                        </div>
                                        ${client.phone ? `
                                        <div class="client-contact small text-muted mt-1">
                                            <i class="fas fa-phone-alt me-1"></i>
                                            ${client.phone}
                                        </div>
                                        ` : ''}
                                    </div>
                                    <div class="status-badge px-2 py-1 rounded ${statusColor} text-white">
                                        ${status}
                                    </div>
                                </div>
                            </div>
                        `;
                    });
                }
            })
            .catch(error => {
                console.error("❌ خطأ أثناء البحث عن العميل:", error);
                clientsListContainer.innerHTML = `<p class="text-danger">حدث خطأ أثناء البحث. يرجى المحاولة مرة أخرى.</p>`;
            });
    } else {
        // إذا كان حقل البحث فارغًا، قم بعرض جميع العملاء
        displayAllClients();
    }
});
function displayAllClients() {
    fetch('/clients/clients_management/clients/all')
        .then(response => response.json())
        .then(data => {
            let clientsListContainer = document.getElementById("clientsList");
            clientsListContainer.innerHTML = "";

            data.forEach(client => {
                let status = client.latest_status ? client.latest_status.status : 'غير محدد';
                let statusColor = getStatusColor(status);

                clientsListContainer.innerHTML += `
                    <div class="client-item p-3 border-bottom hover-bg-light cursor-pointer" data-client-id="${client.id}" onclick="selectClient(${client.id})">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="badge bg-success country-badge">
                                        ${client.country_code || 'SA'}
                                    </span>
                                    <span class="client-number text-muted">#${client.code}</span>
                                    <span class="client-name text-primary fw-medium">${client.trade_name}</span>
                                </div>
                                <div class="client-info small text-muted mt-1">
                                    <i class="far fa-clock me-1"></i>
                                    ${new Date(client.created_at).toLocaleTimeString()} |
                                    ${new Date(client.created_at).toLocaleDateString()}
                                </div>
                                ${client.phone ? `
                                <div class="client-contact small text-muted mt-1">
                                    <i class="fas fa-phone-alt me-1"></i>
                                    ${client.phone}
                                </div>
                                ` : ''}
                            </div>
                            <div class="status-badge px-2 py-1 rounded ${statusColor} text-white">
                                ${status}
                            </div>
                        </div>
                    </div>
                `;
            });
        })
        .catch(error => {
            console.error("❌ خطأ أثناء جلب قائمة العملاء:", error);
            clientsListContainer.innerHTML = `<p class="text-danger">حدث خطأ أثناء جلب قائمة العملاء. يرجى المحاولة مرة أخرى.</p>`;
        });
}

// دالة لتحديد لون الحالة بناءً على القيمة
function getStatusColor(status) {
    switch (status) {
        case 'مديون':
            return 'bg-warning'; // لون أصفر
        case 'دائن':
            return 'bg-danger';  // لون أحمر
        case 'مميز':
            return 'bg-primary'; // لون أزرق
        default:
            return 'bg-secondary'; // لون رمادي (حالة افتراضية)
    }
}


</script>

<script>
let currentClientId = null; // لتخزين معرف العميل الحالي

// دالة لتحميل العميل التالي
function loadNextClient() {
    fetch(`/clients/clients_management/clients/next?currentClientId=${currentClientId}`)
        .then(response => response.json())
        .then(data => {
            if (data.client) {
                currentClientId = data.client.id; // تحديث معرف العميل الحالي
                updateClientDetails(data.client); // تحديث واجهة المستخدم ببيانات العميل الجديد
            } else {
                alert("لا يوجد عملاء آخرين.");
            }
        })
        .catch(error => console.error("❌ خطأ أثناء جلب العميل التالي:", error));
}

// دالة لتحميل العميل السابق
function loadPreviousClient() {
    fetch(`/clients_management/clients/previous?currentClientId=${currentClientId}`)
        .then(response => response.json())
        .then(data => {
            if (data.client) {
                currentClientId = data.client.id; // تحديث معرف العميل الحالي
                updateClientDetails(data.client); // تحديث واجهة المستخدم ببيانات العميل الجديد
            } else {
                alert("لا يوجد عملاء سابقين.");
            }
        })
        .catch(error => console.error("❌ خطأ أثناء جلب العميل السابق:", error));
}

// دالة لتحديث واجهة المستخدم ببيانات العميل
function updateClientDetails(client) {
    document.getElementById("clientName").innerText = client.trade_name || "بدون اسم تجاري";
    document.getElementById("clientPhone").innerText = client.phone || client.mobile || "غير متوفر";
    document.getElementById("clientCity").innerText = `${client.city}, ${client.region}`;

    // تحديث الملاحظات
    let notesTimeline = document.getElementById("notesTimeline");
    notesTimeline.innerHTML = ""; // تفريغ الملاحظات القديمة

    client.notes.forEach(note => {
        notesTimeline.innerHTML += `
            <div class="note-item mb-3">
                <div class="d-flex align-items-center text-muted small mb-1">
                    <i class="far fa-clock me-1"></i> ${new Date(note.created_at).toLocaleString()}
                    <span class="mx-2">•</span>
                    <i class="far fa-user me-1"></i> ${note.process}
                    <span class="mx-2">•</span>
                    <i class="fas fa-info-circle me-1"></i>
                    <span class="badge ${getStatusColor(note.status)}">
                        ${note.status}
                    </span>
                </div>
                <div class="note-description">
                    ${note.description}
                </div>
            </div>
        `;
    });
}

// دالة لتحديد لون الحالة
function getStatusColor(status) {
    switch (status) {
        case 'مديون':
            return 'bg-warning text-dark';
        case 'دائن':
            return 'bg-danger';
        case 'مميز':
            return 'bg-primary';
        default:
            return 'bg-secondary';
    }
}

</script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    fetch('/clients_management/clients/first')
        .then(response => response.json())
        .then(data => {
            if (data.client) {
                currentClientId = data.client.id;
                updateClientDetails(data.client);
            }
        })
        .catch(error => console.error("❌ خطأ أثناء جلب العميل الأول:", error));
});

</script>



    <script>
        let currentClientId = null;

        function loadPreviousClient() {
            const clientItems = Array.from(document.querySelectorAll('.client-item'));
            const currentIndex = clientItems.findIndex(item => item.dataset.clientId == currentClientId);

            if (currentIndex > 0) {
                const prevClientId = clientItems[currentIndex - 1].dataset.clientId;
                loadClientDetails(prevClientId);
            }
        }

        function loadNextClient() {
            const clientItems = Array.from(document.querySelectorAll('.client-item'));
            const currentIndex = clientItems.findIndex(item => item.dataset.clientId == currentClientId);

            if (currentIndex < clientItems.length - 1) {
                const nextClientId = clientItems[currentIndex + 1].dataset.clientId;
                loadClientDetails(nextClientId);
            }
        }

        function updateNavigationButtons() {
            const clientItems = Array.from(document.querySelectorAll('.client-item'));
            const currentIndex = clientItems.findIndex(item => item.dataset.clientId == currentClientId);

            const prevButton = document.getElementById('prevButton');
            const nextButton = document.getElementById('nextButton');

            if (prevButton) {
                prevButton.disabled = currentIndex <= 0;
            }

            if (nextButton) {
                nextButton.disabled = currentIndex >= clientItems.length - 1;
            }
        }

        // Load initial client data when page loads
        document.addEventListener('DOMContentLoaded', function() {
            const firstClient = document.querySelector('.client-item');
            if (firstClient) {
                const clientId = firstClient.dataset.clientId;
                loadClientDetails(clientId);
            }

            // If we have a client ID in the URL, load that client
            const urlParts = window.location.pathname.split('/');
            const clientIdFromUrl = urlParts[urlParts.length - 1];
            if (clientIdFromUrl && !isNaN(clientIdFromUrl)) {
                loadClientDetails(clientIdFromUrl);
            }
        });
    </script>
    <script src="<?php echo e(asset('assets/js/applmintion.js')); ?>"></script>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.blank', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\fawtramsmart\fawtra\resources\views/client/relestion_mang_client.blade.php ENDPATH**/ ?>