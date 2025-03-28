<?php $__env->startSection('title'); ?>
    الفواتير الدورية
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">ادارة الفواتير الدورية</h2>
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
    <?php if(session('success')): ?>
        <div class="alert alert-success">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="alert alert-danger">
            <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?>

    <div class="content-body">
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <!-- مربع اختيار الكل -->


                    <!-- المجموعة الأفقية: Combobox و Dropdown -->

                    <!-- الجزء الخاص بالتصفح -->


                    <!-- الأزرار الإضافية -->
                    <a href="<?php echo e(route('periodic_invoices.create')); ?>"
                        class="btn btn-success btn-sm btn-lg d-flex align-items-center">
                        <i class="fa fa-plus me-2"></i>اشتراك جديد
                    </a>


                </div>
            </div>

        </div>
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>تعليمات</span>
                <button type="button" class="btn-close" aria-label="Close"></button>
            </div>
            <div class="card-body">
                <p>
                    تعرض هذه الصفحة جميع الفواتير الدورية والاشتراكات الجارية. يمكنك عرض كل فاتورة عبر الإنترنت وتعديلها أو
                    حذفها من هذه الصفحة.
                    يمكنك النقر على زر المزيد من الخيارات لتصفية قائمة الفواتير حسب الحاجة - بواسطة رقم الفاتورة، التاريخ،
                    الحالة، تاريخ الاستحقاق، إلخ.
                </p>
            </div>
        </div>
        <div class="card">
            <div class="card-content">
                <div class="card-body">
                    <h4 class="card-title">بحث</h4>
                </div>

                <div class="card-body">
                    <form class="form" method="GET" action="<?php echo e(route('periodic_invoices.index')); ?>">
                        <div class="form-body row">
                            <div class="form-group col-md-4">
                                <label for="name_subscription">اسم الاشتراك</label>
                                <input type="text" id="name_subscription" class="form-control" placeholder="اسم الاشتراك"
                                    name="name_subscription" value="<?php echo e(request('name_subscription')); ?>">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="client_id">العميل</label>
                                <select name="client_id" class="form-control" id="client_id">
                                    <option value="">اختر العميل</option>
                                    <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($client->id); ?>" <?php echo e(request('client_id') == $client->id ? 'selected' : ''); ?>>
                                            <?php echo e($client->trade_name); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>

                        <div class="collapse <?php echo e(request()->hasAny(['repeat_type', 'from_date', 'to_date', 'min_total', 'max_total']) ? 'show' : ''); ?>" id="advancedSearchForm">
                            <div class="form-body row d-flex align-items-center g-0">
                                <div class="form-group col-md-2">
                                    <label for="repeat_type">تخصيص</label>
                                    <select name="repeat_type" class="form-control" id="repeat_type">
                                        <option value="">تخصيص</option>
                                        <option value="1" <?php echo e(request('repeat_type') == '1' ? 'selected' : ''); ?>>شهرياً</option>
                                        <option value="0" <?php echo e(request('repeat_type') == '0' ? 'selected' : ''); ?>>أسبوعياً</option>
                                        <option value="2" <?php echo e(request('repeat_type') == '2' ? 'selected' : ''); ?>>يومياً</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-2">
                                    <label for="from_date">تاريخ (من)</label>
                                    <input type="date" id="from_date" class="form-control" name="from_date"
                                        value="<?php echo e(request('from_date')); ?>">
                                </div>

                                <div class="form-group col-md-2">
                                    <label for="to_date">تاريخ (الى)</label>
                                    <input type="date" id="to_date" class="form-control" name="to_date"
                                        value="<?php echo e(request('to_date')); ?>">
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="min_total">الاجمالي الاكبر من</label>
                                    <input type="number" id="min_total" class="form-control" placeholder="الاجمالي اكبر من"
                                        name="min_total" value="<?php echo e(request('min_total')); ?>">
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="max_total">الاجمالي الاصغر من</label>
                                    <input type="number" id="max_total" class="form-control" placeholder="الاجمالي اصغر من"
                                        name="max_total" value="<?php echo e(request('max_total')); ?>">
                                </div>
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary mr-1 waves-effect waves-light">بحث</button>
                            <a class="btn btn-outline-secondary ml-2 mr-2" data-toggle="collapse" href="#advancedSearchForm">
                                <i class="bi bi-sliders"></i> بحث متقدم
                            </a>
                            <a href="<?php echo e(route('periodic_invoices.index')); ?>" class="btn btn-outline-warning waves-effect waves-light">إلغاء البحث</a>
                        </div>
                    </form>

                </div>

            </div>

        </div>


        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="select-all"></th>
                                <th> رقم المعرف </th>
                                <th>الاسم</th>
                                <th>اسم العميل</th>
                                <th>التاريخ القادم</th>
                                <th>تم إنشاؤها</th>
                                <th>الإجمالي</th>
                                <th>كل</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $periodicInvoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $preInvoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><input type="checkbox" name="selected[]" value="<?php echo e($preInvoice->id); ?>"></td>
                                    <td><?php echo e($preInvoice->id); ?></td>
                                    <td><?php echo e($preInvoice->details_subscription); ?></td>
                                    <td><?php echo e(optional($preInvoice->client)->trade_name ?? 'عميل نقدي'); ?></td>
                                    <td><?php echo e($preInvoice->first_invoice_date ? date('Y-m-d', strtotime($preInvoice->first_invoice_date)) : 'انتهى'); ?>

                                    </td>
                                    <td><?php echo e($preInvoice->created_at ? date('Y-m-d', strtotime($preInvoice->created_at)) : '-'); ?>

                                    </td>
                                    <?php
                                            $currency = $account_setting->currency ?? 'SAR';
                                            $currencySymbol = $currency == 'SAR' || empty($currency) ? '<img src="' . asset('assets/images/Saudi_Riyal.svg') . '" alt="ريال سعودي" width="15" style="vertical-align: middle;">' : $currency;
                                        ?>
                                    <td><?php echo e(number_format($preInvoice->grand_total, 2)); ?>  <?php echo $currencySymbol; ?></td>
                                    <td><?php echo e($preInvoice->repeat_interval); ?>

                                        <?php if($preInvoice->repeat_type == 1): ?>
                                            يوم
                                        <?php elseif($preInvoice->repeat_type == 2): ?>
                                            اسبوع
                                        <?php elseif($preInvoice->repeat_type == 3): ?>
                                            شهري
                                        <?php else: ?>
                                            سنوي
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="<?php echo e(route('periodic_invoices.show', $preInvoice->id)); ?>"
                                                class="btn btn-sm btn-info">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            <a href="<?php echo e(route('periodic_invoices.edit', $preInvoice->id)); ?>"
                                                class="btn btn-sm btn-success">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <form action="<?php echo e(route('periodic_invoices.destroy', $preInvoice->id)); ?>"
                                                method="POST" class="d-inline">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('هل أنت متأكد من الحذف؟')">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-3">
            <div>
                <span>1-<?php echo e($periodicInvoices->count()); ?> من النتائج المعروضة</span>
            </div>
            <div>
                <button class="btn btn-purple" id="bulk-action">
                    <i class="fa fa-cog"></i>
                    للمحدد
                </button>
                <button class="btn btn-danger" id="bulk-delete">
                    <i class="fa fa-trash"></i>
                    حذف
                </button>
            </div>
        </div>
    </div>




<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/sehohoqm/hitstest.sehoool.com/resources/views/sales/periodic_invoices/index.blade.php ENDPATH**/ ?>