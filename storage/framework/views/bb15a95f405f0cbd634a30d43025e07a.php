<?php $__env->startSection('title'); ?>
المنتجات
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
<style>
    .user-avatar {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background-color: #007bff; /* لون الخلفية */
        color: #fff; /* لون النص */
        font-weight: bold;
        font-size: 14px;
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">ادارة المنتجات</h2>
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

    <?php echo $__env->make('layouts.alerts.success', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('layouts.alerts.error', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <div class="content-body">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <div>
                        <strong><?php echo e($product->name); ?> </strong> | <small><?php echo e($product->serial_number); ?>#</small> | <span class="badge badge-pill badge badge-success">في المخزن</span>
                    </div>

                    <div>
                        <a href="<?php echo e(route('products.edit',$product->id)); ?>" class="btn btn-outline-primary">
                            <i class="fa fa-edit"></i>تعديل
                        </a>
                    </div>

                </div>
            </div>
        </div>

        <div class="container" style="max-width: 1200px">
            <div class="card">
                <div class="card-title p-2">
                    <a href="<?php echo e(route('products.edit',$product->id)); ?>" class="btn btn-outline-primary btn-sm">تعديل <i class="fa fa-edit"></i></a>
                    <a href="#" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#modal_DELETE<?php echo e($product->id); ?>">حذف <i class="fa fa-trash"></i></a>
                    <?php if($product->type == "products" || $product->type == "compiled"): ?>
                    <a href="<?php echo e(route('store_permits_management.manual_conversion')); ?>" class="btn btn-outline-success btn-sm">نقل <i class="fa fa-reply-all"></i></a>
                    <a href="<?php echo e(route('store_permits_management.create')); ?>" class="btn btn-outline-info btn-sm">اضف عمليه <i class="fa fa-plus"></i></a>
                    <a href="<?php echo e(route('store_permits_management.manual_disbursement')); ?>" class="btn btn-outline-warning btn-sm">عمليه صرف <i class="fa fa-minus"></i></a>
                    <?php endif; ?>
                </div>
                <div class="card-body">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" aria-controls="home" role="tab" aria-selected="false">معلومات</a>
                        </li>
                        <?php if($product->type == "products" || $product->type == "compiled"): ?>
                        <li class="nav-item">
                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" aria-controls="profile" role="tab" aria-selected="false">حركة المخزون</a>
                        </li>
                        <?php endif; ?>
                        <li class="nav-item">
                            <a class="nav-link" id="about-tab" data-toggle="tab" href="#about" aria-controls="about" role="tab" aria-selected="true">الجدول الزمني</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="activate-tab" data-toggle="tab" href="#activate" aria-controls="about" role="tab" aria-selected="true">سجل النشاطات</a>
                        </li>

                    </ul>

                    <div class="tab-content">

                        <div class="tab-pane active" id="home" aria-labelledby="home-tab" role="tabpanel">
                            <div class="row">

                                <table class="table">
                                    <thead class="table-light">
                                        <tr><?php if($product->type == "products" || $product->type == "compiled"): ?>
                                            <th class="text-center"><i class="feather icon-package text-info font-medium-5 mr-1"></i>اجمالي المخزون</th>
                                            <?php endif; ?>
                                            <th class="text-center"><i class="feather icon-shopping-cart text-warning font-medium-5 mr-1"></i>اجمالي القطع المباعه</th>
                                            <th class="text-center"><i class="feather icon-calendar text-danger font-medium-5 mr-1"></i>آخر 28 أيام</th>
                                            <th class="text-center"><i class="feather icon-calendar text-primary font-medium-5 mr-1"></i>آخر 7 أيام</th>
                                            <th class="text-center"><i class="feather icon-bar-chart-2 text-success font-medium-5 mr-1"></i>متوسط سعر التكلفة</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <?php if($product->type == "products" || $product->type == "compiled"): ?>
                                            <td class="text-center">
                                                <h4 class="text-bold-700"><?php echo e($total_quantity ? number_format($total_quantity) : 'غير متوفر'); ?> <?php echo e($firstTemplateUnit ?? ""); ?></h4>
                                                <br>

                                                <?php if($storeQuantities->isNotEmpty()): ?>
                                                    <?php $__currentLoopData = $storeQuantities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $storeQuantity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <?php if(!empty($storeQuantity->storeHouse)): ?>
                                                            <p>
                                                                <span><?php echo e($storeQuantity->storeHouse->name); ?> :</span>
                                                                <strong><?php echo e(number_format($storeQuantity->total_quantity)); ?></strong>
                                                            </p>
                                                        <?php endif; ?>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php endif; ?>

                                                <a href="<?php echo e(route('products.manual_stock_adjust',$product->id)); ?>" class="btn btn-outline-info">اضف عميله على المخزون</a>
                                            </td>
                                            <?php endif; ?>
                                            <td class="text-center">
                                                <h4 class="text-bold-700"><?php echo e($total_sold ? number_format($total_sold) : 0); ?><small>قطع</small></h4>
                                            </td>
                                            <td class="text-center">
                                                <h4 class="text-bold-700"><?php echo e($sold_last_28_days ? number_format($sold_last_28_days) : 0); ?><small>قطع</small></h4>
                                            </td>
                                            <td class="text-center">
                                                <h4 class="text-bold-700"><?php echo e($sold_last_7_days ? number_format($sold_last_7_days) : 0); ?><small>قطع</small></h4>
                                            </td>
                                            <td class="text-center">
                                                <h4 class="text-bold-700"><?php echo e($average_cost ? number_format($average_cost, 2) . ' ر.س' : 'غير متوفر'); ?></h4>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="card">
                                <div class="card-header">
                                    <strong>التفاصيل :</strong>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <table class="table">
                                            <tr>
                                                <td>
                                                    <?php if($product->images): ?>
                                                        <img src="<?php echo e(asset('assets/uploads/product/'.$product->images)); ?>" alt="img" width="150">
                                                    <?php else: ?>
                                                        <img src="<?php echo e(asset('assets/uploads/no_image.jpg')); ?>" alt="img" width="150">
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <strong>كود المنتج </strong>: <?php echo e($product->serial_number); ?>#
                                                </td>
                                                <td>
                                                    <strong>نوع التتبع</strong><br>
                                                    <small>
                                                        <?php if($product->inventory_type == 0): ?>
                                                        الرقم التسلسلي
                                                        <?php elseif($product->inventory_type == 1): ?>
                                                        رقم الشحنة
                                                        <?php elseif($product->inventory_type == 2): ?>
                                                        تاريخ الانتهاء
                                                        <?php elseif($product->inventory_type == 3): ?>
                                                        رقم الشحنة وتاريخ الانتهاء
                                                        <?php else: ?>
                                                        الكمية فقط
                                                        <?php endif; ?>
                                                    <small>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <?php if($product->type == "compiled"): ?>
                            <div class="card">
                                <div class="card-header">
                                    <strong>منتجات التجميعة :</strong>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <table class="table">
                                            <tr>
                                             <?php $__currentLoopData = $CompiledProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $CompiledProduct): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                             <td>
                                                <b><?php echo e($CompiledProduct->Product->name ?? ""); ?></b>  : <?php echo e($CompiledProduct->qyt ?? ""); ?>

                                             </td>
                                             <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>   
                                             
                                               
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>

                        <div class="tab-pane" id="profile" aria-labelledby="profile-tab" role="tabpanel">
                            <div class="card">
                                <div class="card-content">
                                    <div class="card-body">
                                        <?php if(isset($stock_movements) && !empty($stock_movements) && count($stock_movements) > 0): ?>
                                            <table class="table">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th style="width: 40%">العملية</th>
                                                        <th>حركة</th>
                                                        <th>المخزون بعد</th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    <?php $__currentLoopData = $stock_movements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stock_movement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <?php if($stock_movement->warehousePermits->permission_type == 3): ?>
                                                            
                                                            <tr>
                                                                <td>
                                                                    <strong><?php echo e($stock_movement->warehousePermits->permission_date); ?> (#<?php echo e($stock_movement->warehousePermits->id); ?>)</strong><br>
                                                                    <span>تحويل مخزني (<?php echo e($stock_movement->warehousePermits->number); ?>#)</span><br>
                                                                    <span>🔻 من: <?php echo e($stock_movement->warehousePermits->fromStoreHouse->name); ?></span>
                                                                </td>
                                                                <td>
                                                                    <strong><?php echo e(number_format($stock_movement->quantity)); ?></strong>
                                                                    <i class="feather icon-minus text-danger"></i>
                                                                    <br>
                                                                    <small><abbr class="initialism" title="سعر الوحدة"><?php echo e($product->sale_price ?? 0.00); ?>&nbsp;ر.س</abbr></small>
                                                                </td>
                                                                <td>
                                                                    <strong><?php echo e(number_format($stock_movement->stock_after)); ?></strong><br>
                                                                    <small><abbr title="سعر الوحدة"><?php echo e($product->sale_price); ?> ر.س</abbr></small>
                                                                </td>
                                                            </tr>

                                                            
                                                            <tr>
                                                                <td>
                                                                    <strong><?php echo e($stock_movement->warehousePermits->permission_date); ?> (#<?php echo e($stock_movement->warehousePermits->id); ?>)</strong><br>
                                                                    <span>تحويل مخزني (<?php echo e($stock_movement->warehousePermits->number); ?>#)</span><br>
                                                                    <span>🔺 إلى: <?php echo e($stock_movement->warehousePermits->toStoreHouse->name); ?></span>
                                                                </td>
                                                                <td>
                                                                    <strong><?php echo e(number_format($stock_movement->quantity)); ?></strong>
                                                                    <i class="feather icon-plus text-success"></i>
                                                                    <br>
                                                                    <small><abbr class="initialism" title="سعر الوحدة"><?php echo e($product->sale_price ?? 0.00); ?>&nbsp;ر.س</abbr></small>
                                                                </td>
                                                                <td>
                                                                    <?php
                                                                        $stockBeforeTo = \App\Models\ProductDetails::where('product_id', $product->id)
                                                                            ->where('store_house_id', $stock_movement->warehousePermits->to_store_house_id)
                                                                            ->sum('quantity');
                                                                        $stockAfterTo = $stockBeforeTo + $stock_movement->quantity;
                                                                    ?>
                                                                    <strong><?php echo e(number_format($stockAfterTo)); ?></strong><br>
                                                                    <small><abbr title="سعر الوحدة"><?php echo e($product->sale_price); ?> ر.س</abbr></small>
                                                                </td>
                                                            </tr>

                                                       
                                                        <?php elseif($stock_movement->warehousePermits->permission_type != 10): ?>
                                                            
                                                            <tr>
                                                                <td>
                                                                    <strong><?php echo e($stock_movement->warehousePermits->permission_date); ?> (#<?php echo e($stock_movement->warehousePermits->id); ?>)</strong><br>
                                                                    <span>
                                                                        <?php if($stock_movement->warehousePermits->permission_type == 1): ?>
                                                                            إضافة مخزن
                                                                        <?php elseif($stock_movement->warehousePermits->permission_type == 2): ?>
                                                                            صرف مخزن
                                                                        <?php endif; ?>
                                                                        (<?php echo e($stock_movement->warehousePermits->number); ?>#)
                                                                    </span><br>
                                                                    <span><?php echo e($stock_movement->warehousePermits->storeHouse->name); ?></span>
                                                                </td>
                                                                <td>
                                                                    <strong>
                                                                        <?php echo e(number_format($stock_movement->quantity)); ?>

                                                                        <?php if($stock_movement->warehousePermits->permission_type == 1): ?>
                                                                            <i class="feather icon-plus text-success"></i>
                                                                        <?php elseif($stock_movement->warehousePermits->permission_type == 2): ?>
                                                                            <i class="feather icon-minus text-danger"></i>
                                                                        <?php endif; ?>
                                                                    </strong>
                                                                    <br>
                                                                    <small><abbr class="initialism" title="سعر الوحدة"><?php echo e($product->sale_price ?? 0.00); ?>&nbsp;ر.س</abbr></small>
                                                                </td>
                                                                <td>
                                                                    <strong><?php echo e(number_format($stock_movement->stock_after)); ?></strong><br>
                                                                    <small><abbr title="سعر الوحدة"><?php echo e($product->sale_price); ?> ر.س</abbr></small>
                                                                </td>

                                                            </tr>
                                                                      
                                                        <?php endif; ?>
                                                        <?php if($stock_movement->warehousePermits->permission_type == 10): ?>     
                                                        
                                                        <tr>
                                                           <td>
                                                               <strong><?php echo e($stock_movement->warehousePermits->permission_date); ?> (#<?php echo e($stock_movement->warehousePermits->id); ?>)</strong><br>
                                                               <span> فاتورة رقم (<?php echo e($stock_movement->warehousePermits->number); ?>#)</span><br>
                                                             
                                                           </td>
                                                           <td>
                                                               <strong><?php echo e(number_format($stock_movement->quantity)); ?></strong>
                                                               <i class="feather icon-minus text-danger"></i>
                                                               <br>
                                                               <small><abbr class="initialism" title="سعر الوحدة"><?php echo e($product->sale_price ?? 0.00); ?>&nbsp;ر.س</abbr></small>
                                                           </td>
                                                           <td>
                                                               <strong><?php echo e(number_format($stock_movement->stock_after)); ?></strong><br>
                                                               <small><abbr title="سعر الوحدة"><?php echo e($product->sale_price); ?> ر.س</abbr></small>
                                                           </td>
                                                       </tr> 
                                                       <?php endif; ?>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </tbody>
                                            </table>
                                        <?php else: ?>
                                            <div class="alert alert-danger text-xl-center" role="alert">
                                                <p class="mb-0">
                                                    لا توجد عمليات مضافه حتى الان !!
                                                </p>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane" id="about" aria-labelledby="about-tab" role="tabpanel">
                            <div class="card">
                                <div class="card-content">
                                    <div class="card-body">
                                        <?php if(isset($stock_movements) && !empty($stock_movements) && count($stock_movements) > 0): ?>
                                            <ul class="activity-timeline timeline-left list-unstyled">
                                                <?php $__currentLoopData = $stock_movements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $movement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <li>
                                                        <div class="timeline-icon bg-success">
                                                            <i class="feather icon-package font-medium-2"></i>
                                                        </div>
                                                        <div class="timeline-info">
                                                            <p>
                                                                <?php if($movement->warehousePermits->permission_type == 2): ?>
                                                                    أنقص <strong><?php echo e($movement->warehousePermits->user->name); ?></strong> <strong><?php echo e($movement->quantity); ?></strong> وحدة من مخزون <strong><a href="<?php echo e(route('products.show', $product->id)); ?>" target="_blank">#<?php echo e($product->serial_number); ?> (<?php echo e($product->name); ?>)</a></strong> يدويا (رقم العملية: <strong>#<?php echo e($movement->warehousePermits->number); ?></strong>)، وسعر الوحدة: <strong><?php echo e($movement->unit_price); ?>&nbsp;ر.س</strong>، وأصبح المخزون الباقي من المنتج: <strong><?php echo e($movement->stock_after); ?></strong> وأصبح المخزون <strong><?php echo e($movement->warehousePermits->storeHouse->name); ?></strong> رصيده <strong><?php echo e($movement->stock_after); ?></strong> , متوسط السعر: <strong><?php echo e($average_cost); ?>&nbsp;ر.س</strong>
                                                                <?php else: ?>
                                                                    أضاف <strong><?php echo e($movement->warehousePermits->user->name); ?></strong> <strong><?php echo e($movement->quantity); ?></strong> وحدة إلى مخزون <strong><a href="<?php echo e(route('products.show', $product->id)); ?>" target="_blank">#<?php echo e($product->serial_number); ?> (<?php echo e($product->name); ?>)</a></strong> يدويا (رقم العملية: <strong>#<?php echo e($movement->warehousePermits->number); ?></strong>)، وسعر الوحدة: <strong><?php echo e($movement->unit_price); ?>&nbsp;ر.س</strong>، وأصبح المخزون الباقي من المنتج: <strong><?php echo e($movement->stock_after); ?></strong> وأصبح المخزون <strong><?php echo e($movement->warehousePermits->storeHouse->name); ?></strong> رصيده <strong><?php echo e($movement->stock_after); ?></strong> , متوسط السعر: <strong><?php echo e($average_cost); ?>&nbsp;ر.س</strong>
                                                                <?php endif; ?>
                                                            </p>
                                                            <br>
                                                            <span>
                                                                <i class="fa fa-clock-o"></i> <?php echo e($movement->warehousePermits->permission_date); ?> - <span class="tip observed tooltipstered" data-title="<?php echo e($movement->warehousePermits->user->ip_address); ?>"> <i class="fa fa-user"></i> <?php echo e($movement->warehousePermits->user->name); ?></span> - <i class="fa fa-building"></i> <?php echo e($movement->warehousePermits->storeHouse->name); ?>

                                                            </span>
                                                        </div>
                                                    </li>
                                                    <hr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </ul>
                                        <?php else: ?>
                                            <div class="alert alert-danger text-xl-center" role="alert">
                                                <p class="mb-0">
                                                    لا توجد عمليات مضافه حتى الان !!
                                                </p>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane" id="activate" aria-labelledby="activate-tab" role="tabpanel">
                            <ul class="activity-timeline timeline-left list-unstyled">
                                <?php $__empty_1 = true; $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <li>
                                        <!-- أيقونة النشاط -->
                                        <div class="timeline-icon bg-<?php echo e($log->type_log == 'create' ? 'success' : 'warning'); ?>">
                                            <i class="feather icon-<?php echo e($log->type_log == 'create' ? 'plus' : 'edit'); ?> font-medium-2"></i>
                                        </div>
                        
                                        <!-- معلومات النشاط -->
                                        <div class="timeline-info">
                                            <p class="mb-1">
                                                <!-- المستخدم والتاريخ -->
                                                <span class="badge badge-pill badge-dark"><?php echo e($log->user->name ?? "مستخدم غير معروف"); ?></span>
                                                قام بـ <?php echo e($log->type_log == 'create' ? 'إضافة' : 'تعديل'); ?> منتج:
                                                <span class="badge badge-pill badge-dark"><?php echo e($log->Product->name ?? ""); ?> <?php echo e($log->Product->code ?? ""); ?></span>
                                                بتاريخ <span class="badge badge-pill badge-dark"><?php echo e($log->created_at->format('Y-m-d H:i') ?? ""); ?></span>
                                            </p>
                        
                                            <!-- تفاصيل النشاط -->
                                            <div class="details mt-2">
                                                <?php if($log->type_log == 'create'): ?>
                                                    <!-- تفاصيل الإضافة -->
                                                    <div class="mb-2">
                                                        <span class="badge badge-pill badge-success">الاسم: <?php echo e($log->Product->name ?? ""); ?></span>
                                                        <span class="badge badge-pill badge-success">سعر البيع: <?php echo e($log->Product->sale_price ?? ""); ?></span>
                                                        <span class="badge badge-pill badge-success">سعر الشراء: <?php echo e($log->Product->purchase_price ?? ""); ?></span>
                                                        <span class="badge badge-pill badge-success">الرقم التسلسلي: <?php echo e($log->Product->serial_number ?? ""); ?></span>
                                                    </div>
                                                    <div class="mb-2">
                                                        <span class="badge badge-pill badge-success">الوصف: <?php echo e($log->Product->description ?? "لا يوجد"); ?></span>
                                                        <span class="badge badge-pill badge-success">الضريبة: القيمة المضافة</span>
                                                        <span class="badge badge-pill badge-success">تتبع المخزن: نعم</span>
                                                    </div>
                                                    <div class="mb-2">
                                                        <span class="badge badge-pill badge-success">متوسط السعر: <?php echo e($log->Product->min_sale_price ?? "غير محدد"); ?></span>
                                                        <span class="badge badge-pill badge-success">
                                                            النوع:
                                                            <?php switch($log->Product->type):
                                                                case ('products'): ?> منتج <?php break; ?>
                                                                <?php case ('services'): ?> خدمة <?php break; ?>
                                                                <?php case ('compiled'): ?> منتج تجميعي <?php break; ?>
                                                                <?php default: ?> غير محدد
                                                            <?php endswitch; ?>
                                                        </span>
                                                        <span class="badge badge-pill badge-success">
                                                            نوع الخصم:
                                                            <?php switch($log->Product->discount_type):
                                                                case (1): ?> نسبة مئوية <?php break; ?>
                                                                <?php case (2): ?> قيمة ثابتة <?php break; ?>
                                                                <?php default: ?> غير محدد
                                                            <?php endswitch; ?>
                                                        </span>
                                                        <span class="badge badge-pill badge-success">
                                                            الحالة:
                                                            <?php switch($log->Product->status):
                                                                case (1): ?> نشط <?php break; ?>
                                                                <?php case (2): ?> موقوف <?php break; ?>
                                                                <?php case (3): ?> غير نشط <?php break; ?>
                                                                <?php default: ?> غير محدد
                                                            <?php endswitch; ?>
                                                        </span>
                                                    </div>
                                                <?php else: ?>
                                                    <!-- تفاصيل التعديل -->
                                                    <div class="mb-2">
                                                        <span class="badge badge-pill badge-success">
                                                            <?php echo e($log->Product->name ?? ''); ?>

                                                        </span>
                                                        <span class="mx-2">→</span>
                                                        

                                                        <span class="badge badge-pill badge-secondary text-decoration-line-through">
                                                            <?php echo e($log->old_value ?? ''); ?>

                                                        </span>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </li>
                                    <hr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <!-- رسالة إذا لم توجد سجلات -->
                                    <div class="alert alert-danger text-center" role="alert">
                                        <p class="mb-0">لا توجد عمليات مضافة حتى الآن!</p>
                                    </div>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Modal delete -->
        <div class="modal fade text-left" id="modal_DELETE<?php echo e($product->id); ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #EA5455 !important;">
                        <h4 class="modal-title" id="myModalLabel1" style="color: #FFFFFF">حذف <?php echo e($product->name); ?></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" style="color: #DC3545">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <strong>
                            هل انت متاكد من انك تريد الحذف ؟
                        </strong>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light waves-effect waves-light" data-dismiss="modal">الغاء</button>
                        <a href="<?php echo e(route('products.delete',$product->id)); ?>" class="btn btn-danger waves-effect waves-light">تأكيد</a>
                    </div>
                </div>
            </div>
        </div>
        <!--end delete-->

    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>

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

<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/sehohoqm/hitstest.sehoool.com/resources/views/stock/products/show.blade.php ENDPATH**/ ?>