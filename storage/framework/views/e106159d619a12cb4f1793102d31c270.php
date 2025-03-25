<?php $__env->startSection('title'); ?>
    ادراة اوامر التوريد
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">ادراة اوامر التوريد</h2>
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
        <div class="container-fluid">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <!-- مربع اختيار الكل -->


                        <!-- المجموعة الأفقية: Combobox و Dropdown -->
                        <div class="d-flex align-items-center">



                        </div>

                        <!-- الجزء الخاص بالتصفح -->
                        <div class="d-flex align-items-center">
                            <!-- زر الصفحة السابقة -->
                            <button class="btn btn-outline-secondary btn-sm" aria-label="الصفحة السابقة">
                                <i class="fa fa-angle-right"></i>
                            </button>

                            <!-- أرقام الصفحات -->
                            <nav class="mx-2">
                                <ul class="pagination pagination-sm mb-0">
                                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item active"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item"><a class="page-link" href="#">4</a></li>
                                    <li class="page-item"><a class="page-link" href="#">5</a></li>
                                </ul>
                            </nav>

                            <!-- زر الصفحة التالية -->
                            <button class="btn btn-outline-secondary btn-sm" aria-label="الصفحة التالية">
                                <i class="fa fa-angle-left"></i>
                            </button>
                        </div>

                        <!-- الأزرار الإضافية -->
                        <a href="<?php echo e(route('SupplyOrders.create')); ?>"
                            class="btn btn-success btn-sm d-flex align-items-center">
                            <i class="fa fa-plus me-2"></i>اضافة امر توريد
                        </a>


                    </div>
                </div>

            </div>

            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <h4 class="card-title">بحث</h4>
                    </div>

                    <div class="card-body">
                        <form class="form" method="GET" action="<?php echo e(route('SupplyOrders.index')); ?>">
                            <div class="form-body row">
                                <!-- رقم الطلب -->
                                <div class="form-group col-md-4">
                                    <label for="order_number" class="sr-only">رقم الطلب</label>
                                    <input type="text" id="order_number" class="form-control" placeholder="رقم الطلب" name="order_number" value="<?php echo e(request('order_number')); ?>">
                                </div>

                                <!-- اسم الطلب -->
                                <div class="form-group col-md-4">
                                    <label for="name" class="sr-only">اسم الطلب</label>
                                    <input type="text" id="name" class="form-control" placeholder="اسم الطلب" name="name" value="<?php echo e(request('name')); ?>">
                                </div>

                                <!-- العميل -->
                                <div class="form-group col-md-4">
                                    <label for="client_id" class="sr-only">العميل</label>
                                    <select id="client_id" class="form-control" name="client_id">
                                        <option value="">اختر العميل</option>
                                        <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($client->id); ?>" <?php echo e(request('client_id') == $client->id ? 'selected' : ''); ?>>
                                                <?php echo e($client->trade_name); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-body row">
                                <!-- الموظف -->
                                <div class="form-group col-md-4">
                                    <label for="employee_id" class="sr-only">الموظف</label>
                                    <select id="employee_id" class="form-control" name="employee_id">
                                        <option value="">اختر الموظف</option>
                                        <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($employee->id); ?>" <?php echo e(request('employee_id') == $employee->id ? 'selected' : ''); ?>>
                                                <?php echo e($employee->full_name); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                <!-- التعيين إلى -->
                                <div class="form-group col-md-4">
                                    <label for="assigned_to" class="sr-only">التعيين إلى</label>
                                    <select id="assigned_to" class="form-control" name="assigned_to">
                                        <option value="">التعيين إلى</option>
                                        <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($employee->id); ?>" <?php echo e(request('assigned_to') == $employee->id ? 'selected' : ''); ?>>
                                                <?php echo e($employee->full_name); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                <!-- الحالة -->
                                <div class="form-group col-md-4">
                                    <label for="status" class="sr-only">الحالة</label>
                                    <select id="status" class="form-control" name="status">
                                        <option value="">الحالة</option>
                                        <option value="pending" <?php echo e(request('status') == 'pending' ? 'selected' : ''); ?>>قيد الانتظار</option>
                                        <option value="approved" <?php echo e(request('status') == 'approved' ? 'selected' : ''); ?>>موافق عليه</option>
                                        <option value="rejected" <?php echo e(request('status') == 'rejected' ? 'selected' : ''); ?>>مرفوض</option>
                                    </select>
                                </div>
                            </div>

                            <!-- بحث متقدم -->
                            <div class="collapse" id="advancedSearchForm">
                                <div class="form-body row d-flex align-items-center g-0">
                                    <!-- تاريخ البدء -->
                                    <div class="form-group col-md-2">
                                        <label for="date_type_1" class="sr-only">نوع تاريخ البدء</label>
                                        <select id="date_type_1" class="form-control" name="date_type_1">
                                            <option value="">نوع تاريخ البدء</option>
                                            <option value="monthly" <?php echo e(request('date_type_1') == 'monthly' ? 'selected' : ''); ?>>شهريًا</option>
                                            <option value="weekly" <?php echo e(request('date_type_1') == 'weekly' ? 'selected' : ''); ?>>أسبوعيًا</option>
                                            <option value="daily" <?php echo e(request('date_type_1') == 'daily' ? 'selected' : ''); ?>>يوميًا</option>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-2">
                                        <label for="from_date_1" class="sr-only">من تاريخ البدء</label>
                                        <input type="date" id="from_date_1" class="form-control" name="from_date_1" value="<?php echo e(request('from_date_1')); ?>">
                                    </div>

                                    <div class="form-group col-md-2">
                                        <label for="to_date_1" class="sr-only">إلى تاريخ البدء</label>
                                        <input type="date" id="to_date_1" class="form-control" name="to_date_1" value="<?php echo e(request('to_date_1')); ?>">
                                    </div>

                                    <!-- تاريخ الاستلام -->
                                    <div class="form-group col-md-2">
                                        <label for="date_type_2" class="sr-only">نوع تاريخ الاستلام</label>
                                        <select id="date_type_2" class="form-control" name="date_type_2">
                                            <option value="">نوع تاريخ الاستلام</option>
                                            <option value="monthly" <?php echo e(request('date_type_2') == 'monthly' ? 'selected' : ''); ?>>شهريًا</option>
                                            <option value="weekly" <?php echo e(request('date_type_2') == 'weekly' ? 'selected' : ''); ?>>أسبوعيًا</option>
                                            <option value="daily" <?php echo e(request('date_type_2') == 'daily' ? 'selected' : ''); ?>>يوميًا</option>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-2">
                                        <label for="from_date_2" class="sr-only">من تاريخ الاستلام</label>
                                        <input type="date" id="from_date_2" class="form-control" name="from_date_2" value="<?php echo e(request('from_date_2')); ?>">
                                    </div>

                                    <div class="form-group col-md-2">
                                        <label for="to_date_2" class="sr-only">إلى تاريخ الاستلام</label>
                                        <input type="date" id="to_date_2" class="form-control" name="to_date_2" value="<?php echo e(request('to_date_2')); ?>">
                                    </div>
                                </div>
                            </div>

                            <!-- الأزرار -->
                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary mr-1 waves-effect waves-light">بحث</button>
                                <a class="btn btn-outline-secondary ml-2 mr-2" data-toggle="collapse" data-target="#advancedSearchForm">
                                    <i class="bi bi-sliders"></i> بحث متقدم
                                </a>
                                <button type="reset" class="btn btn-outline-warning waves-effect waves-light">إعادة تعيين</button>
                            </div>
                        </form>
                    </div>

                </div>

            </div>
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">

                        <!-- Existing filter buttons -->
                        <div class="d-flex gap-2 flex-wrap align-items-center">
                            <a href="<?php echo e(route('SupplyOrders.index', ['filter' => 'results'])); ?>"
                               class="btn btn-sm <?php echo e(request('filter') == 'results' ? 'btn-success' : 'btn-outline-success'); ?>">
                                <i class="fas fa-chart-line me-1"></i> النتائج
                                <span class="badge bg-white text-success ms-1">(<?php echo e($resultsCount); ?>)</span>
                            </a>

                            <a href="<?php echo e(route('SupplyOrders.index')); ?>"
                               class="btn btn-sm <?php echo e(!request('filter') ? 'btn-primary' : 'btn-outline-primary'); ?>">
                                <i class="fas fa-list me-1"></i> الكل
                                <span class="badge bg-white text-primary ms-1">(<?php echo e($totalCount); ?>)</span>
                            </a>

                            <a href="<?php echo e(route('SupplyOrders.index', ['filter' => 'open'])); ?>"
                               class="btn btn-sm <?php echo e(request('filter') == 'open' ? 'btn-success' : 'btn-outline-success'); ?>">
                                <i class="fas fa-unlock me-1"></i> مفتوح
                                <span class="badge bg-white text-success ms-1">(<?php echo e($openCount); ?>)</span>
                            </a>

                            <a href="<?php echo e(route('SupplyOrders.index', ['filter' => 'closed'])); ?>"
                               class="btn btn-sm <?php echo e(request('filter') == 'closed' ? 'btn-danger' : 'btn-outline-danger'); ?>">
                                <i class="fas fa-lock me-1"></i> مغلق
                                <span class="badge bg-white text-danger ms-1">(<?php echo e($closedCount); ?>)</span>
                            </a>
                        </div>

                    </div>


                <div class="card-body">
                    <?php if(isset($supplyOrders) && !$supplyOrders->isEmpty()): ?>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>رقم الأمر</th>
                                    <th>اسم الأمر</th>

                                    <th>العميل</th>
                                    <th>الميزانية</th>
                                    <th>الحالة</th>
                                    <th style="width: 10%">الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $supplyOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($order->order_number); ?></td>
                                        <td><?php echo e($order->name); ?></td>

                                        <td><?php echo e($order->client->trade_name ?? 'غير محدد'); ?></td>
                                        <td>
                                            <?php echo e(number_format($order->budget ?? 0, 2)); ?>

                                            <?php echo e($order->currency_name ?? 'SAR'); ?>

                                        </td>
                                        <td>
                                            <?php if($order->status == 1): ?>
                                                <span class="badge badge-success">مفتوح</span>
                                            <?php elseif($order->status == 2): ?>
                                                <span class="badge badge-danger">مغلق</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <div class="dropdown">
                                                    <button class="btn bg-gradient-info fa fa-ellipsis-v mr-1 mb-1 btn-sm"
                                                        type="button" id="dropdownMenuButton<?php echo e($order->id); ?>"
                                                        data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                    </button>
                                                    <div class="dropdown-menu"
                                                        aria-labelledby="dropdownMenuButton<?php echo e($order->id); ?>">
                                                        <li>
                                                            <a class="dropdown-item"
                                                                href="<?php echo e(route('SupplyOrders.show', $order->id)); ?>">
                                                                <i class="fa fa-eye me-2 text-primary"></i>عرض
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item"
                                                                href="<?php echo e(route('SupplyOrders.edit', $order->id)); ?>">
                                                                <i class="fa fa-edit me-2 text-success"></i>تعديل
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item text-danger" href="#"
                                                                data-toggle="modal"
                                                                data-target="#modal_DELETE<?php echo e($order->id); ?>">
                                                                <i class="fa fa-trash me-2"></i>حذف
                                                            </a>
                                                        </li>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Modal delete -->
                                            <div class="modal fade text-left" id="modal_DELETE<?php echo e($order->id); ?>"
                                                tabindex="-1" role="dialog" aria-labelledby="myModalLabel1"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-scrollable" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header"
                                                            style="background-color: #EA5455 !important;">
                                                            <h4 class="modal-title" id="myModalLabel1"
                                                                style="color: #FFFFFF">حذف أمر التوريد <?php echo e($order->name); ?>

                                                            </h4>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true"
                                                                    style="color: #DC3545">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <strong>
                                                                هل أنت متأكد من أنك تريد الحذف ؟
                                                            </strong>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button"
                                                                class="btn btn-light waves-effect waves-light"
                                                                data-dismiss="modal">إلغاء</button>
                                                            <form action="<?php echo e(route('SupplyOrders.destroy', $order->id)); ?>"
                                                                method="POST" class="d-inline">
                                                                <?php echo csrf_field(); ?>
                                                                <?php echo method_field('DELETE'); ?>
                                                                <button type="submit"
                                                                    class="btn btn-danger waves-effect waves-light">تأكيد</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end delete-->
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <div class="alert alert-danger text-xl-center" role="alert">
                            <p class="mb-0">
                                لا توجد أوامر تشغيل مضافة حتى الآن !!
                            </p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php $__env->stopSection(); ?>
    <?php $__env->startSection('scripts'); ?>
        <script>
            function copyOrder(orderId) {
                // Implement copy functionality
                alert('سيتم نسخ الأمر: ' + orderId);
            }

            // Confirm delete
            document.addEventListener('DOMContentLoaded', function() {
                const deleteForms = document.querySelectorAll('.delete-form');
                deleteForms.forEach(form => {
                    form.addEventListener('submit', function(e) {
                        if (!confirm('هل أنت متأكد من حذف هذا الأمر؟')) {
                            e.preventDefault();
                        }
                    });
                });
            });
        </script>
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/sehohoqm/hitstest.sehoool.com/resources/views/supplyOrders/index.blade.php ENDPATH**/ ?>