<?php $__env->startSection('title'); ?>
    تقرير مبيعات البنود
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/report.css')); ?>">
    <style>
        body {
            direction: rtl;
            text-align: right;
            font-family: 'Tajawal', sans-serif;
            background-color: #f8f9fa;
        }

        .card {
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .card-title {
            font-weight: bold;
            color: #2c3e50;
        }

        .table thead th {
            background-color: #1e90ff;
            color: white;
            font-weight: bold;
        }

        .table tbody td {
            vertical-align: middle;
        }

        .table-hover tbody tr:hover {
            background-color: #f1f8ff;
        }

        .btn-primary {
            background: linear-gradient(135deg, #1e90ff, #00bfff);
            border: none;
            padding: 10px 20px;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            opacity: 0.9;
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: linear-gradient(135deg, #6c757d, #868e96);
            border: none;
            padding: 10px 20px;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            opacity: 0.9;
            transform: translateY(-2px);
        }

        .text-muted {
            color: #6c757d !important;
        }

        .report-link {
            padding: 5px 10px;
            border-radius: 5px;
            margin-left: 5px;
            text-decoration: none;
        }

        .report-link.details {
            background-color: #1e90ff;
            color: white;
        }

        .report-link.summary {
            background-color: #28a745;
            color: white;
        }

        .report-link:hover {
            opacity: 0.8;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid mt-4">
    <div class="card shadow">
        <div class="card-body">
            <h5 class="card-title">
                <?php if($isSummary): ?>
                    <i class="fas fa-clipboard-list"></i> ملخص تقرير مبيعات البنود حسب
                <?php else: ?>
                    <i class="fas fa-file-alt"></i> تفاصيل تقرير مبيعات البنود حسب
                <?php endif; ?>
                <?php echo e(match($filter) {
                    'item' => 'البند',
                    'category' => 'التصنيف',
                    'employee' => 'الموظف',
                    'sales_manager' => 'مندوب المبيعات',
                    'client' => 'العميل',
                    default => 'البند'
                }); ?>

            </h5>

            <form action="<?php echo e(route('salesReports.byItem')); ?>" method="GET">
                <input type="hidden" name="filter" value="<?php echo e($filter); ?>">
                <?php if($isSummary): ?>
                    <input type="hidden" name="summary" value="1">
                <?php endif; ?>

                <div class="row g-3">
                    <!-- حالة الفاتورة -->
                    <div class="col-md-3">
                        <label for="status"><i class="fas fa-receipt"></i> حالة الفاتورة</label>
                        <select name="status" class="form-control">
                            <option value="">الكل</option>
                            <option value="فاتورة" <?php echo e(request('status') == 'فاتورة' ? 'selected' : ''); ?>>فاتورة</option>
                            <option value="مسودة" <?php echo e(request('status') == 'مسودة' ? 'selected' : ''); ?>>مسودة</option>
                        </select>
                    </div>

                    <!-- البند -->
                    <div class="col-md-3">
                        <label for="item"><i class="fas fa-box"></i> البند</label>
                        <select name="item" class="form-control">
                            <option value="">الكل</option>
                            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($product->id); ?>" <?php echo e(request('item') == $product->id ? 'selected' : ''); ?>><?php echo e($product->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <!-- الموظف -->
                    <div class="col-md-3">
                        <label for="employee"><i class="fas fa-user-tie"></i> الموظف</label>
                        <select name="employee" class="form-control">
                            <option value="">الكل</option>
                            <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($employee->id); ?>" <?php echo e(request('employee') == $employee->id ? 'selected' : ''); ?>><?php echo e($employee->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <!-- العميل -->
                    <div class="col-md-3">
                        <label for="client"><i class="fas fa-user"></i> العميل</label>
                        <select name="client" class="form-control">
                            <option value="">اختر العميل</option>
                            <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($client->id); ?>" <?php echo e(request('client') == $client->id ? 'selected' : ''); ?>><?php echo e($client->trade_name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <!-- الفرع -->
                    <div class="col-md-3">
                        <label for="branch"><i class="fas fa-building"></i> الفرع</label>
                        <select name="branch" class="form-control">
                            <option value="">الكل</option>
                            <?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($branch->id); ?>" <?php echo e(request('branch') == $branch->id ? 'selected' : ''); ?>><?php echo e($branch->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <!-- التصنيف -->
                    <div class="col-md-3">
                        <label for="category"><i class="fas fa-layer-group"></i> التصنيف</label>
                        <select name="category" class="form-control">
                            <option value="">اختر التصنيف</option>
                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($category->id); ?>" <?php echo e(request('category') == $category->id ? 'selected' : ''); ?>><?php echo e($category->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <!-- المخزن -->
                    <div class="col-md-3">
                        <label for="storehouse"><i class="fas fa-warehouse"></i> المخزن</label>
                        <select name="storehouse" class="form-control">
                            <option value="">اختر المخزن</option>
                            <?php $__currentLoopData = $storehouses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $storehouse): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($storehouse->id); ?>" <?php echo e(request('storehouse') == $storehouse->id ? 'selected' : ''); ?>><?php echo e($storehouse->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <!-- نوع الفاتورة -->
                    <div class="col-md-3">
                        <label for="invoice_type"><i class="fas fa-file-invoice"></i> نوع الفاتورة</label>
                        <select name="invoice_type" class="form-control">
                            <option value="">الكل</option>
                            <option value="1" <?php echo e(request('invoice_type') == '1' ? 'selected' : ''); ?>>مرتجع</option>
                            <option value="2" <?php echo e(request('invoice_type') == '2' ? 'selected' : ''); ?>>اشعار مدين</option>
                            <option value="3" <?php echo e(request('invoice_type') == '3' ? 'selected' : ''); ?>>اشعار دائن</option>
                        </select>
                    </div>

                    <!-- الفترة من / إلى -->
                    <div class="col-md-3">
                        <label for="from_date"><i class="fas fa-calendar-alt"></i> من تاريخ</label>
                        <input type="date" name="from_date" class="form-control" value="<?php echo e(request('from_date')); ?>">
                    </div>
                    <div class="col-md-3">
                        <label for="to_date"><i class="fas fa-calendar-alt"></i> إلى تاريخ</label>
                        <input type="date" name="to_date" class="form-control" value="<?php echo e(request('to_date')); ?>">
                    </div>

                    <!-- زر البحث -->
                    <div class="col-md-12 text-center mt-4">
                        <div class="row g-3 align-items-center">
                            <!-- زر البحث -->
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-search"></i> عرض التقرير
                                </button>
                            </div>

                            <!-- زر إعادة التعيين -->
                            <div class="col-md-3">
                                <a href="<?php echo e(route('salesReports.byItem', ['filter' => $filter, 'summary' => $isSummary ? '1' : null])); ?>" class="btn btn-warning w-100">
                                    <i class="fas fa-sync-alt"></i> إعادة تعيين
                                </a>
                            </div>

                            <!-- دروب داون للفترة -->
                            <div class="col-md-3">
                                <div class="dropdown">
                                    <button class="btn btn-info dropdown-toggle w-100" type="button" id="periodDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                        اختر الفترة
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="periodDropdown">
                                        <li>
                                            <a class="dropdown-item" href="#" onclick="selectPeriod('')">الكل</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#" onclick="selectPeriod('daily')">يومي</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#" onclick="selectPeriod('weekly')">أسبوعي</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#" onclick="selectPeriod('monthly')">شهري</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#" onclick="selectPeriod('yearly')">سنوي</a>
                                        </li>
                                    </ul>
                                    <input type="hidden" name="period" id="periodInput" value="<?php echo e(request('period')); ?>">
                                </div>
                            </div>

                            <!-- زر تصدير إلى Excel -->
                            <div class="col-md-3">
                                <button type="button" class="btn btn-success w-100" id="exportExcel">
                                    <i class="fas fa-file-excel"></i> تصدير إلى Excel
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Results Section -->
    <div class="card mt-4">
        <div class="card-body">
            <table class="table table-hover table-striped" id="reportTable">
                <thead class="thead-dark">
                    <tr>
                        <th>المعرف</th>
                        <th>كود المنتج</th>
                        <th>التاريخ</th>
                        <th>الموظف</th>
                        <th>الفاتورة</th>
                        <th>العميل</th>
                        <th>سعر الوحدة</th>
                        <th>الكمية</th>
                        <th>الخصم</th>
                        <th>الاجمالي</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        // تجميع البيانات حسب الاسم أولاً
                        $groupedData = [];
                        foreach($reportData as $data) {
                            $groupedData[$data['name']][] = $data;
                        }

                        $grandTotalQuantity = 0;
                        $grandTotalDiscount = 0;
                        $grandTotalAmount = 0;
                    ?>

                    <?php $__empty_1 = true; $__currentLoopData = $groupedData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name => $items): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <?php
                            $groupTotalQuantity = 0;
                            $groupTotalDiscount = 0;
                            $groupTotalAmount = 0;
                        ?>

                        <tr class="table-primary">
                            <td colspan="10" class="text-center font-weight-bold">
                                <?php echo e(match($filter) {
                                    'item' => 'البند: ',
                                    'category' => 'التصنيف: ',
                                    'employee' => 'الموظف: ',
                                    'sales_manager' => 'مندوب المبيعات: ',
                                    'client' => 'العميل: ',
                                    default => ''
                                }); ?><?php echo e($name); ?>

                            </td>
                        </tr>

                        <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($data['id']); ?></td>
                                <td><?php echo e($data['product_code']); ?></td>
                                <td><?php echo e($data['date']); ?></td>
                                <td><?php echo e($data['employee']); ?></td>
                                <td><?php echo e($data['invoice']); ?></td>
                                <td><?php echo e($data['client']); ?></td>
                                <td><?php echo e(number_format($data['unit_price'], 2)); ?></td>
                                <td><?php echo e($data['quantity']); ?></td>
                                <td><?php echo e(number_format($data['discount'], 2)); ?></td>
                                <td><?php echo e(number_format($data['total'], 2)); ?></td>
                            </tr>

                            <?php
                                $groupTotalQuantity += $data['quantity'];
                                $groupTotalDiscount += $data['discount'];
                                $groupTotalAmount += $data['total'];

                                $grandTotalQuantity += $data['quantity'];
                                $grandTotalDiscount += $data['discount'];
                                $grandTotalAmount += $data['total'];
                            ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        <tr class="table-secondary">
                            <td colspan="7" class="text-end font-weight-bold">مجموع <?php echo e($name); ?></td>
                            <td><?php echo e(number_format($groupTotalQuantity, 2)); ?></td>
                            <td><?php echo e(number_format($groupTotalDiscount, 2)); ?></td>
                            <td><?php echo e(number_format($groupTotalAmount, 2)); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="10" class="text-center text-muted">لا توجد بيانات لعرضها</td>
                        </tr>
                    <?php endif; ?>

                    <tr class="table-success">
                        <td colspan="7" class="text-end font-weight-bold">المجموع العام</td>
                        <td><?php echo e(number_format($grandTotalQuantity, 2)); ?></td>
                        <td><?php echo e(number_format($grandTotalDiscount, 2)); ?></td>
                        <td><?php echo e(number_format($grandTotalAmount, 2)); ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.5/xlsx.full.min.js"></script>
    <script>
        // دالة لتصدير الجدول إلى Excel
        document.getElementById('exportExcel').addEventListener('click', function() {
            const table = document.getElementById('reportTable');
            const wb = XLSX.utils.table_to_book(table, { sheet: "تقرير المبيعات" });
            XLSX.writeFile(wb, 'تقرير_المبيعات.xlsx');
        });

        // دالة لتحديد الفترة
        function selectPeriod(period) {
            document.getElementById('periodInput').value = period;
            document.getElementById('periodDropdown').innerText = period ? {
                'daily': 'يومي',
                'weekly': 'أسبوعي',
                'monthly': 'شهري',
                'yearly': 'سنوي'
            }[period] : 'اختر الفترة';
        }

        // تحديث النص عند تحميل الصفحة
        document.addEventListener('DOMContentLoaded', function() {
            const period = document.getElementById('periodInput').value;
            if (period) {
                selectPeriod(period);
            }
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\fawtramsmart\fawtra\resources\views/reports/sals/salesRport/itemReport.blade.php ENDPATH**/ ?>