<?php $__env->startSection('title'); ?>
    عرض السلفة
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">عرض السلفة </h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="">الرئيسيه</a></li>
                            <li class="breadcrumb-item active">عرض</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body p-1">
            <div class="d-flex justify-content-between align-items-center">

                <div class="d-flex align-items-center gap-3">
                    <span class="text-muted">الدفعة القادمة:</span>
                    <span>25/03/2025</span>
                    <span class="text-muted px-2">|</span>
                    <span>سلفة #1</span>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <button class="btn btn-sm btn-light"><i class="fa fa-chevron-right"></i></button>
                    <button class="btn btn-sm btn-light"><i class="fa fa-chevron-left"></i></button>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-title p-2 d-flex align-items-center gap-2">
            <a href="<?php echo e(route('ancestor.index')); ?>"
                class="btn btn-outline-primary btn-sm d-inline-flex align-items-center justify-content-center px-3"
                style="min-width: 90px;">
                تعديل <i class="fa fa-edit ms-1"></i>
            </a>
            <div class="vr"></div>

            <a href="#"
                class="btn btn-outline-info btn-sm d-inline-flex align-items-center justify-content-center px-3"
                style="min-width: 90px;">
                نسخ <i class="fa fa-copy ms-1"></i>
            </a>
            <div class="vr"></div>

            <a href="#"
                class="btn btn-outline-danger btn-sm d-inline-flex align-items-center justify-content-center px-3"
                style="min-width: 90px;">
                حذف <i class="fa fa-trash ms-1"></i>
            </a>
            <div class="vr"></div>

            <a href="#"
                class="btn btn-outline-success btn-sm d-inline-flex align-items-center justify-content-center px-3"
                style="min-width: 90px;">
                قم بالدفع القسط <i class="fa fa-money-bill ms-1"></i>
            </a>
            <div class="vr"></div>

            <a href="#"
                class="btn btn-outline-warning btn-sm d-inline-flex align-items-center justify-content-center px-3"
                style="min-width: 90px;">
                تضمين ورسوم <i class="fa fa-plus-circle ms-1"></i>
            </a>
            <div class="vr"></div>

            <a href="#"
                class="btn btn-outline-secondary btn-sm d-inline-flex align-items-center justify-content-center px-3"
                style="min-width: 90px;">
                اضافة ملاحظة/مرفق <i class="fa fa-paperclip ms-1"></i>
            </a>
            <div class="vr"></div>

            <div class="dropdown d-inline-block">
                <button class="btn btn-outline-dark btn-sm d-inline-flex align-items-center justify-content-center px-3"
                    style="min-width: 90px;" type="button" id="printDropdown" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    المطبوعات <i class="fa fa-print ms-1"></i>
                </button>
                <ul class="dropdown-menu py-1" aria-labelledby="printDropdown">
                    <li><a class="dropdown-item d-flex align-items-center" href="#"><i
                                class="fa fa-file-alt me-2 text-primary"></i>Contract Layout 1</a></li>
                    <li><a class="dropdown-item d-flex align-items-center" href="#"><i
                                class="fa fa-file-alt me-2 text-primary"></i>Contract Layout 2</a></li>
                    <li><a class="dropdown-item d-flex align-items-center" href="#"><i
                                class="fa fa-file-alt me-2 text-primary"></i>Contract Layout 3</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item d-flex align-items-center" href="#"><i
                                class="fa fa-file-pdf me-2 text-danger"></i>نموذج 1 عقد</a></li>
                    <li><a class="dropdown-item d-flex align-items-center" href="#"><i
                                class="fa fa-file-pdf me-2 text-danger"></i>نموذج 2 عقد</a></li>
                    <li><a class="dropdown-item d-flex align-items-center" href="#"><i
                                class="fa fa-file-pdf me-2 text-danger"></i>نموذج 3 عقد</a></li>
                </ul>
            </div>
        </div>

        <div class="card-body">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#details" role="tab">
                        <span>التفاصيل</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#installments" role="tab">
                        <span>الاقساط</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#activity" role="tab">
                        <span>سجل النشاطات</span>
                    </a>
                </li>
            </ul>

            <div class="tab-content p-3">
                <!-- تبويب التفاصيل -->
                <div class="tab-pane active" id="details" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td class="text-start" style="width: 50%">
                                        <div class="mb-2">
                                            <label class="text-muted">موظف:</label>
                                            <div><?php echo e($ancestor->employee->full_name); ?> </div>
                                        </div>
                                        <div class="mb-2">
                                            <label class="text-muted">المبلغ:</label>
                                            <div class="mt-1">
                                                <div style="width: fit-content;">
                                                    <div
                                                        style="font-weight: bold; margin-bottom: 4px; position: relative;">
                                                        <div
                                                            style="border-bottom: 2px solid #ffc107; width: <?php echo e(($ancestor->installment_amount / $ancestor->amount) * 100); ?>%; position: absolute; bottom: -2px;">
                                                        </div>
                                                        <div style="border-bottom: 1px solid #dee2e6; width: fit-content;">
                                                            <?php echo e(number_format($ancestor->amount, 2)); ?> ر.س
                                                        </div>
                                                    </div>
                                                    <div style="color: #666; font-size: 0.9em;">
                                                        <span><?php echo e(number_format($ancestor->installment_amount, 2)); ?> ر.س
                                                            مدفوعة</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-2">
                                            <label class="text-muted">معدل السداد:</label>
                                            <div>
                                                <?php if($ancestor->payment_rate == 1): ?>
                                                    اسبوعي
                                                <?php elseif($ancestor->payment_rate == 2): ?>
                                                    شهري
                                                <?php else: ?>
                                                    سنوي
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <div class="mb-2">
                                            <label class="text-muted">الخزنة:</label>
                                            <div><?php echo e($ancestor->treasury->name); ?></div>
                                        </div>
                                    </td>
                                    <td class="text-start" style="width: 50%">
                                        <div class="mb-2">
                                            <label class="text-muted">تاريخ التقديم:</label>
                                            <div><?php echo e($ancestor->submission_date); ?></div>
                                        </div>
                                        <div class="mb-2">
                                            <label class="text-muted">قيمة القسط:</label>
                                            <div><?php echo e(number_format($ancestor->installment_amount, 2)); ?></div>
                                        </div>
                                        <div class="mb-2">
                                            <label class="text-muted">تاريخ بدء الأقساط:</label>
                                            <div><?php echo e($ancestor->installment_start_date); ?></div>
                                        </div>
                                        <div class="mb-2">
                                            <label class="text-muted">مصروف:</label>
                                            <div>#000001</div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <div class="mb-2">
                                            <label class="text-muted">ملاحظة:</label>
                                            <div>lp</div>
                                        </div>
                                        <div class="mb-2">
                                            <label class="text-muted">الدفع من قسيمة الراتب:</label>
                                            <i class="fas fa-check-circle text-success"></i>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane" id="installments" role="tabpanel">
                    <div class="d-flex justify-content-between align-items-center mb-3"
                        style=" background-color: #f8f9fa">
                        <h5 class="mb-0">تفاصيل القسط</h5>
                        <div class="d-flex align-items-center gap-2">
                            <button class="btn btn-sm btn-light"><i class="fa fa-chevron-right"></i></button>
                            <button class="btn btn-sm btn-light"><i class="fa fa-chevron-left"></i></button>
                            <span class="text-muted">1 - 5 من 5</span>
                        </div>

                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th class="text-end">الاسم</th>
                                    <th class="text-end">الفترة</th>
                                    <th class="text-end">قسائم الرواتب</th>
                                    <th class="text-end">المبالغ</th>
                                    <th class="text-end">الحالة</th>
                                    <th class="text-end">ترتيب بواسطة</th>
                                    <th class="text-end" style="width: 10%"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Payrun (2024-12-30) SAR #1</td>
                                    <td>
                                        <div>02 ديسمبر - 30 ديسمبر</div>
                                        <small class="text-muted">30 ديسمبر</small>
                                    </td>
                                    <td>1</td>
                                    <td>4,267 ر.س</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <i class="fa fa-circle text-secondary me-1" style="font-size: 8px;"></i>
                                            تم إنشاؤها
                                        </div>
                                    </td>
                                    <td>
                                        <div>0 مدفوعة / 0 موافق عليه</div>
                                        <small class="text-muted">تم إنشاؤها</small>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <div class="dropdown">
                                                <button class="btn bg-gradient-info fa fa-ellipsis-v mr-1 mb-1 btn-sm"
                                                    type="button" id="dropdownMenuButton303" data-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false"></button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton303">
                                                    <li>
                                                        <a class="dropdown-item" href="">
                                                            <i class="fa fa-eye me-2 text-primary"></i>عرض
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="">
                                                            <i class="fa fa-edit me-2 text-success"></i>تعديل
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item text-danger" href="#"
                                                            data-toggle="modal" data-target="#modal_DELETE">
                                                            <i class="fa fa-trash me-2"></i>حذف
                                                        </a>
                                                    </li>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-end align-items-center mt-3" style="background-color: #f8f9fa ">
                        <div class="d-flex align-items-center gap-2">
                            <button class="btn btn-sm btn-light"><i class="fa fa-chevron-right"></i></button>
                            <button class="btn btn-sm btn-light"><i class="fa fa-chevron-left"></i></button>
                            <span class="text-muted">1 - 5 من 5</span>
                        </div>
                    </div>
                </div>

                <!-- تبويب سجل النشاطات -->
                <div class="tab-pane" id="activity" role="tabpanel">
                    <div class="timeline p-4">
                        <!-- يمكن إضافة سجل النشاطات هنا -->
                        <p class="text-muted text-center">لا توجد نشاطات حتى الآن</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/sehohoqm/hitstest.sehoool.com/resources/views/salaries/ancestor/show.blade.php ENDPATH**/ ?>