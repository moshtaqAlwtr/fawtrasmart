<?php $__env->startSection('title'); ?>
    الأذون المخزنية
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">الأذون المخزنية</h2>
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
                            <div>بحث</div>
                            <nav aria-label="Page navigation">
                                <ul class="pagination pagination-sm mb-0">
                                    <!-- زر الانتقال إلى أول صفحة -->
                                    <?php if($wareHousePermits->onFirstPage()): ?>
                                        <li class="page-item disabled">
                                            <span class="page-link border-0 rounded-pill" aria-label="First">
                                                <i class="fas fa-angle-double-right"></i>
                                            </span>
                                        </li>
                                    <?php else: ?>
                                        <li class="page-item">
                                            <a class="page-link border-0 rounded-pill"
                                                href="<?php echo e($wareHousePermits->url(1)); ?>" aria-label="First">
                                                <i class="fas fa-angle-double-right"></i>
                                            </a>
                                        </li>
                                    <?php endif; ?>

                                    <!-- زر الانتقال إلى الصفحة السابقة -->
                                    <?php if($wareHousePermits->onFirstPage()): ?>
                                        <li class="page-item disabled">
                                            <span class="page-link border-0 rounded-pill" aria-label="Previous">
                                                <i class="fas fa-angle-right"></i>
                                            </span>
                                        </li>
                                    <?php else: ?>
                                        <li class="page-item">
                                            <a class="page-link border-0 rounded-pill"
                                                href="<?php echo e($wareHousePermits->previousPageUrl()); ?>" aria-label="Previous">
                                                <i class="fas fa-angle-right"></i>
                                            </a>
                                        </li>
                                    <?php endif; ?>

                                    <!-- عرض رقم الصفحة الحالية -->
                                    <li class="page-item">
                                        <span class="page-link border-0 bg-light rounded-pill px-3">
                                            صفحة <?php echo e($wareHousePermits->currentPage()); ?> من
                                            <?php echo e($wareHousePermits->lastPage()); ?>

                                        </span>
                                    </li>

                                    <!-- زر الانتقال إلى الصفحة التالية -->
                                    <?php if($wareHousePermits->hasMorePages()): ?>
                                        <li class="page-item">
                                            <a class="page-link border-0 rounded-pill"
                                                href="<?php echo e($wareHousePermits->nextPageUrl()); ?>" aria-label="Next">
                                                <i class="fas fa-angle-left"></i>
                                            </a>
                                        </li>
                                    <?php else: ?>
                                        <li class="page-item disabled">
                                            <span class="page-link border-0 rounded-pill" aria-label="Next">
                                                <i class="fas fa-angle-left"></i>
                                            </span>
                                        </li>
                                    <?php endif; ?>

                                    <!-- زر الانتقال إلى آخر صفحة -->
                                    <?php if($wareHousePermits->hasMorePages()): ?>
                                        <li class="page-item">
                                            <a class="page-link border-0 rounded-pill"
                                                href="<?php echo e($wareHousePermits->url($wareHousePermits->lastPage())); ?>"
                                                aria-label="Last">
                                                <i class="fas fa-angle-double-left"></i>
                                            </a>
                                        </li>
                                    <?php else: ?>
                                        <li class="page-item disabled">
                                            <span class="page-link border-0 rounded-pill" aria-label="Last">
                                                <i class="fas fa-angle-double-left"></i>
                                            </span>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </nav>

                            <div>

                                <div class="btn-group dropdown mr-1">
                                    <button type="button"
                                        class="btn btn-outline-primary dropdown-toggle waves-effect waves-light"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="feather icon-plus"></i> اضافة
                                    </button>
                                    <div class="dropdown-menu" x-placement="top-start"
                                        style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, -193px, 0px);">
                                        <a class="dropdown-item" href="<?php echo e(route('store_permits_management.create')); ?>">إضافة
                                            يدوي</a>
                                        <a class="dropdown-item"
                                            href="<?php echo e(route('store_permits_management.manual_disbursement')); ?>">صرف يدوي</a>
                                        <a class="dropdown-item"
                                            href="<?php echo e(route('store_permits_management.manual_conversion')); ?>">تحويل يدوي</a>
                                    </div>





                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <form class="form" method="GET" action="<?php echo e(route('store_permits_management.index')); ?>">
                        <div class="form-body row">
                            <div class="form-group col-md-4">
                                <label for="">فرع</label>
                                <select name="branch" class="form-control select2">
                                    <option value="">جميع الفروع</option>
                                    <?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($branch->id); ?>"
                                            <?php echo e(request('branch') == $branch->id ? 'selected' : ''); ?>>
                                            <?php echo e($branch->name); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="">الاذن المخزني</label>
                                <input type="text" class="form-control" placeholder="ادخل الإسم او الكود" name="keywords"
                                    value="<?php echo e(request('keywords')); ?>">
                            </div>

                            <div class="form-group col-md-4">
                                <label for="">مصدر الاذن</label>
                                <select name="permission_type" class="form-control">
                                    <option value="">الكل</option>
                                    <option value="1">إذن إضافة مخزن</option>
                                    <option value="2">إذن صرف مخزن</option>
                                    <option value="22">أمر تصنيع المنتج الرئيسي</option>
                                    <option value="21">أمر تصنيع طلب توريد المواد الهالكة</option>
                                    <option value="13">ورقة جرد منصرف</option>
                                    <option value="14">ورقة جرد وارد</option>
                                    <option value="3">فاتورة</option>
                                    <option value="4">فاتورة مرتجعة</option>
                                    <option value="5">إشعار دائن</option>
                                    <option value="6">فاتورة شراء</option>
                                    <option value="7">مرتجع مشتريات</option>
                                    <option value="15">اشعار مدين المشتريات</option>
                                    <option value="8">تحويل يدوي</option>
                                    <option value="12">POS Shift Outbound</option>
                                    <option value="11">POS Shift Inbound</option>
                                    <option value="16">أمر تصنيع البنود المرتجعة</option>
                                    <option value="18">أمر تصنيع لصرف المواد</option>
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="">الرقم المعرف</label>
                                <input type="text" class="form-control" placeholder="ادخل الرقم المعرف"
                                    name="id" value="<?php echo e(request('id')); ?>">
                            </div>

                            <div class="form-group col-md-4">
                                <label for="">المستودع</label>
                                <select name="store_house" class="form-control select2">
                                    <option value="">جميع المستودعات</option>
                                    <?php $__currentLoopData = $storeHouses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $storeHouse): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($storeHouse->id); ?>"
                                            <?php echo e(request('store_house') == $storeHouse->id ? 'selected' : ''); ?>>
                                            <?php echo e($storeHouse->name); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="">العميل</label>
                                <select name="client" class="form-control select2">
                                    <option value="">اختر العميل</option>
                                    <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($client->id); ?>"
                                            <?php echo e(request('client') == $client->id ? 'selected' : ''); ?>>
                                            <?php echo e($client->trade_name); ?><?php echo e($client->code ?? ''); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="">الموردين</label>
                                <select name="supplier" class="form-control select2">
                                    <option value="">اختر المورد</option>
                                    <?php $__currentLoopData = $suppliers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $supplier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($supplier->id); ?>"
                                            <?php echo e(request('supplier') == $supplier->id ? 'selected' : ''); ?>>
                                            <?php echo e($supplier->trade_name); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>

                        <!-- Advanced Search -->
                        <div class="collapse" id="advancedSearchForm">
                            <div class="form-body row">
                                <div class="form-group col-md-4">
                                    <label for="">الحاله</label>
                                    <select class="form-control" name="status">
                                        <option value="">الكل</option>
                                        <option value="1" <?php echo e(request('status') == '1' ? 'selected' : ''); ?>>نشط
                                        </option>
                                        <option value="0" <?php echo e(request('status') == '0' ? 'selected' : ''); ?>>غير نشط
                                        </option>
                                    </select>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="">اضيفت بواسطة</label>
                                    <select class="form-control select2" name="created_by">
                                        <option value="">اي موظف</option>
                                        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($user->id); ?>"
                                                <?php echo e(request('created_by') == $user->id ? 'selected' : ''); ?>>
                                                <?php echo e($user->name); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="">المنتجات</label>
                                    <select class="form-control select2" name="product">
                                        <option value="">اختر المنتج</option>
                                        <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($product->id); ?>"
                                                <?php echo e(request('product') == $product->id ? 'selected' : ''); ?>>
                                                <?php echo e($product->name); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                <div class="form-group col-4">
                                    <label for="">من تاريخ</label>
                                    <input type="date" class="form-control" name="from_date"
                                        value="<?php echo e(request('from_date')); ?>">
                                </div>

                                <div class="form-group col-4">
                                    <label for="">الي تاريخ</label>
                                    <input type="date" class="form-control" name="to_date"
                                        value="<?php echo e(request('to_date')); ?>">
                                </div>
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary mr-1 waves-effect waves-light">بحث</button>
                            <a class="btn btn-outline-secondary ml-2 mr-2" data-toggle="collapse"
                                data-target="#advancedSearchForm">
                                <i class="bi bi-sliders"></i> بحث متقدم
                            </a>
                            <a href="<?php echo e(route('store_permits_management.index')); ?>"
                                class="btn btn-outline-danger waves-effect waves-light">الغاء الفلترة</a>
                        </div>
                    </form>
                </div>

            </div>

        </div>

        <?php if(@isset($wareHousePermits) && !@empty($wareHousePermits) && count($wareHousePermits) > 0): ?>
            <div class="card">
                <div class="card-body">
                    <table class="table">
                        <?php $__currentLoopData = $wareHousePermits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tbody>
                                <tr>
                                    <td>
                                        <p>#<?php echo e($item->number); ?> - <?php echo e($item->created_at); ?></p>
                                        <p><strong class="mr-1">مؤسسة اعمال خاصة</strong> <small
                                                class="text-muted">فاتوره مبيعات 2</small></p>
                                        <span class="mr-1"> <i class="fa fa-arrow-down"></i>
                                            <?php if($item->permission_type == 1): ?>
                                                إذن إضافة مخزن
                                            <?php elseif($item->permission_type == 2): ?>
                                                إذن صرف مخزن
                                            <?php else: ?>
                                                تحويل يدوي
                                            <?php endif; ?> : <strong>
                                                <?php if($item->permission_type == 3): ?>
                                                    <?php echo e($item->fromStoreHouse->name); ?> - <?php echo e($item->toStoreHouse->name); ?>

                                                <?php else: ?>
                                                    <?php echo e($item->storeHouse->name); ?>

                                                <?php endif; ?>
                                            </strong>
                                        </span> <span> <i class="fa fa-user"></i> بواسطة :
                                            <strong><?php echo e($item->user->name); ?></strong></span>
                                    </td>
                                    <td>
                                        <p><strong>أنشأت</strong></p>
                                        <p><span class="mr-1"><i class="fa fa-calendar"></i>
                                                <?php echo e($item->permission_date); ?></span> <span><i class="fa fa-building"></i>
                                                <?php echo e($item->user->branch->name ?? ''); ?></span></p>
                                        <small class="text-muted"><?php echo e(Str::limit($item->details, 80)); ?></small>
                                    </td>
                                    <td style="width: 20%">
                                        <span class="badge badge badge-success badge-pill float-right"
                                            style="margin-left: 10rem">تمت الموافقة</span>
                                    </td>
                                    <td style="width: 10%">
                                        <div class="btn-group mt-1">
                                            <div class="dropdown">
                                                <button class="btn bg-gradient-info fa fa-ellipsis-v mr-1 mb-1 btn-sm"
                                                    type="button"id="dropdownMenuButton303" data-toggle="dropdown"
                                                    aria-haspopup="true"aria-expanded="false"></button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton303">
                                                    <li>
                                                        <a class="dropdown-item" href="#">
                                                            <i class="fa fa-eye me-2 text-primary"></i>عرض
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item"
                                                            href="<?php echo e(route('store_permits_management.edit', $item->id)); ?>">
                                                            <i class="fa fa-edit me-2 text-success"></i>تعديل
                                                        </a>
                                                    </li>

                                                    <li>
                                                        <a class="dropdown-item text-danger" href="#"
                                                            data-toggle="modal"
                                                            data-target="#modal_DELETE<?php echo e($item->id); ?>">
                                                            <i class="fa fa-trash me-2"></i>حذف
                                                        </a>
                                                    </li>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <!-- Modal delete -->
                                    <div class="modal fade text-left" id="modal_DELETE<?php echo e($item->id); ?>"
                                        tabindex="-1" role="dialog" aria-labelledby="myModalLabel1"
                                        aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-scrollable" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header" style="background-color: #EA5455 !important;">
                                                    <h4 class="modal-title" id="myModalLabel1" style="color: #FFFFFF">حذف
                                                        أذن مخزني</h4>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true" style="color: #DC3545">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <strong>
                                                        هل انت متاكد من انك تريد الحذف ؟
                                                    </strong>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light waves-effect waves-light"
                                                        data-dismiss="modal">الغاء</button>
                                                    <a href="<?php echo e(route('store_permits_management.delete', $item->id)); ?>"
                                                        class="btn btn-danger waves-effect waves-light">تأكيد</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end delete-->
                                </tr>
                            </tbody>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </table>

                </div>
            </div>
        <?php else: ?>
            <div class="alert alert-danger text-xl-center" role="alert">
                <p class="mb-0">
                    لا توجد أذون مخزنية مضافه حتى الان !!
                </p>
            </div>
        <?php endif; ?>
        
    </div>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('scripts'); ?>



<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\fawtramsmart\fawtra\resources\views/stock/store_permits_management/index.blade.php ENDPATH**/ ?>