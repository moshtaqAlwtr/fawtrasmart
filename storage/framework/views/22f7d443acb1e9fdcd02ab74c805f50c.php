<?php $__env->startSection('title'); ?>
    المخزون
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

    <div class="content-body">

        <?php echo $__env->make('layouts.alerts.error', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php echo $__env->make('layouts.alerts.success', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <div class="card">
            <div class="card-content">
                <div class="card-body">
                    <div class="card-title">
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <div>بحث في المنتجات</div>
                            <form action="<?php echo e(route('products.import')); ?>" method="POST" enctype="multipart/form-data">
                                <?php echo csrf_field(); ?>
                                <div class="form-group">
                                    <label for="file">تحميل ملف Excel أو CSV</label>
                                    <input type="file" name="file" class="form-control" required>
                                </div>
                                <button type="submit" class="btn btn-primary">استيراد المنتجات</button>
                            </form>

                            <div class="d-flex justify-content-start align-items-center gap-2">
                                <button class="btn btn-outline-primary">
                                    <i class="fa fa-calendar-alt me-2"></i> مجموعة المنتجات
                                </button>


                                <!-- زر الإضافة مع مسافة صغيرة -->
                                <div class="btn-group px-1">
                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        إضافة
                                    </button>
                                    <div class="dropdown-menu">
                                        <?php if(optional($account_setting)->business_type == 'products'): ?>
                                            <a class="dropdown-item" href="<?php echo e(route('products.create')); ?>">منتج جديد</a>
                                        <?php elseif(optional($account_setting)->business_type == 'services'): ?>
                                            <a class="dropdown-item" href="<?php echo e(route('products.create_services')); ?>">خدمة جديدة</a>

                                        <?php elseif(optional($account_setting)->business_type == 'both'): ?>
                                            <a class="dropdown-item" href="<?php echo e(route('products.create')); ?>">منتج جديد</a>
                                            <a class="dropdown-item" href="<?php echo e(route('products.create_services')); ?>">خدمة جديدة</a>
                                        <?php else: ?>
                                            <a class="dropdown-item" href="<?php echo e(route('products.create')); ?>">منتج جديد</a>
                                        <?php endif; ?>
                                         
                                         <?php if (! ($role === false)): ?>
                                         <a class="dropdown-item" href="<?php echo e(route('products.compiled')); ?>">منتج تجميعي</a>
                                     <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



                <div class="card-body">
                    <form class="form" method="GET" action="<?php echo e(route('products.search')); ?>">
                        <div class="form-body row">
                            <div class="form-group col-md-4">
                                <label for="">البحث بكلمة مفتاحية</label>
                                <input type="text" class="form-control" placeholder="ادخل الإسم او الكود"name="keywords">
                            </div>

                            <div class="form-group col-md-4">
                                <label for="">التصنيف</label>
                                <select name="category" class="form-control" id="">
                                    <option value=""> جميع التصنيفات</option>
                                    <option value="1">منتج</option>
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="">الماركة</label>
                                <select name="brand" class="form-control" id="">
                                    <option value="">جميع الماركات</option>
                                    <option value="nike"></option>
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <select class="form-control" name="status">
                                    <option value="">الحالة</option>
                                    <option value="1">نشط</option>
                                    <option value="2">متوقف</option>
                                    <option value="3">غير نشط</option>
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <select class="form-control" name="track_inventory">
                                    <option value="">جميع انواع التتبع</option>
                                    <option value="0">الرقم التسلسلي</option>
                                    <option value="1">رقم الشحنة</option>
                                    <option value="2">تاريخ الانتهاء</option>
                                    <option value="3">رقم الشحنة وتاريخ الانتهاء</option>
                                    <option value="4">الكمية فقط</option>
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="feedback2" class="sr-only">باركود</label>
                                <input type="text" id="feedback2" class="form-control"
                                    placeholder="باركود"name="barcode">
                            </div>
                        </div>
                        <!-- Hidden Div -->
                        <div class="collapse" id="advancedSearchForm">
                            <div class="form-body row">

                                <div class="form-group col-4">
                                    <label for="">من تاريخ</label>
                                    <input type="date" class="form-control" name="from_date">
                                </div>

                                <div class="form-group col-4">
                                    <label for="">الي تاريخ</label>
                                    <input type="date" class="form-control" name="to_date">
                                </div>

                                <div class="form-group col-4">
                                    <label for="">كود المنتج</label>
                                    <input type="text" class="form-control" name="product_code">
                                </div>

                            </div>

                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary mr-1 waves-effect waves-light">بحث</button>

                            <a class="btn btn-outline-secondary ml-2 mr-2" data-toggle="collapse"
                                data-target="#advancedSearchForm">
                                <i class="bi bi-sliders"></i> بحث متقدم
                            </a>
                            <a href="<?php echo e(route('products.index')); ?>"
                                class="btn btn-outline-danger waves-effect waves-light">الغاء الفلترة</a>
                        </div>
                    </form>

                </div>

            </div>

        </div>

        <?php if(isset($products) && !empty($products) && count($products) > 0): ?>
            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="row border-bottom py-2 align-items-center">
                            <!-- اسم المنتج -->
                            <div class="col-md-3">
                                <p class="mb-0"><?php echo e($product->name); ?></p>
                                <small class="text-muted">#<?php echo e($product->serial_number); ?></small>
                            </div>

                            <!-- تاريخ الإنشاء والمستخدم -->
                            <div class="col-md-3">
                                <p class="mb-0"><small><?php echo e($product->created_at); ?></small></p>
                                <small class="text-muted">بواسطة: <?php echo e($product->user->name ?? ''); ?></small>
                            </div>

                            <!-- حالة المنتج -->
                            <div class="col-md-2 text-center">
                                <?php if($product->type == "products" || $product->type == "compiled"): ?>
                                    <?php if($product->totalQuantity() > 0): ?>
                                        <span class="badge badge-success">في المخزن</span>
                                        <br>
                                        <small><i class="fa fa-cubes"></i> <?php echo e(number_format($product->totalQuantity())); ?>

                                            متاح</small>
                                    <?php else: ?>
                                        <span class="badge badge-danger">مخزون نفد</span>
                                        <br>
                                        <small><i class="fa fa-cubes"></i> <?php echo e(number_format($product->totalQuantity())); ?>

                                            متاح</small>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <span
                                        class="badge
                                    <?php echo e($product->status == 0 ? 'badge-primary' : ($product->status == 1 ? 'badge-danger' : 'badge-secondary')); ?>">
                                        <?php echo e($product->status == 0 ? 'نشط' : ($product->status == 1 ? 'موقوف' : 'غير نشط')); ?>

                                    </span>
                                <?php endif; ?>
                            </div>

                            <!-- الأسعار -->
                            <div class="col-md-2 d-flex flex-column text-center">
                                <?php if($product->purchase_price): ?>
                                    <p class="mb-0"><i class="fa fa-shopping-cart"></i>
                                        <small><?php echo e($product->purchase_price); ?></small></p>
                                <?php endif; ?>
                                <?php if($product->sale_price): ?>
                                    <p class="mb-0"><i class="fa fa-car"></i> <small><?php echo e($product->sale_price); ?></small>
                                    </p>
                                <?php endif; ?>
                            </div>

                            <!-- الإجراءات -->
                            <div class="col-md-2 text-end">
                                <div class="btn-group">
                                    <div class="dropdown">
                                        <button class="btn bg-gradient-info fa fa-ellipsis-v mr-1 mb-1 btn-sm"
                                            type="button" id="dropdownMenuButton303" data-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false"></button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton303">
                                            <li><a class="dropdown-item"
                                                    href="<?php echo e(route('products.show', $product->id)); ?>">
                                                    <i class="fa fa-eye me-2 text-primary"></i>عرض</a></li>
                                            <li><a class="dropdown-item"
                                                    href="<?php echo e(route('products.edit', $product->id)); ?>">
                                                    <i class="fa fa-edit me-2 text-success"></i>تعديل</a></li>
                                            <li><a class="dropdown-item text-danger" href="#" data-toggle="modal"
                                                    data-target="#modal_DELETE<?php echo e($product->id); ?>">
                                                    <i class="fa fa-trash me-2"></i>حذف</a></li>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal delete -->
                <div class="modal fade text-left" id="modal_DELETE<?php echo e($product->id); ?>" tabindex="-1" role="dialog"
                    aria-labelledby="myModalLabel1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable" role="document">
                        <div class="modal-content">
                            <div class="modal-header bg-danger text-white">
                                <h4 class="modal-title" id="myModalLabel1">حذف <?php echo e($product->name); ?></h4>
                                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <strong>هل انت متأكد من أنك تريد الحذف؟</strong>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light" data-dismiss="modal">إلغاء</button>
                                <a href="<?php echo e(route('products.delete', $product->id)); ?>" class="btn btn-danger">تأكيد</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End delete -->
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php else: ?>
            <p class="text-center text-muted">لا توجد منتجات متاحة.</p>
        <?php endif; ?>

        <?php echo e($products->links('pagination::bootstrap-5')); ?>

    </div>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('scripts'); ?>



<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\fawtrasmart\fawtrasmart\resources\views/stock/products/index.blade.php ENDPATH**/ ?>