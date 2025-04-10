<?php $__env->startSection('title'); ?>
    تقرير مبيعات المنتجات اليومية
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <link rel="stylesheet" href="<?php echo e(asset('assets/css/report.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid mt-4">
        <div class="card shadow">

            <div class="card-body">
                <h5 class="card-title">
                    <?php switch($reportPeriod):
                        case ('daily'): ?>
                            تقرير المبيعات اليومية للمنتجات
                        <?php break; ?>

                        <?php case ('weekly'): ?>
                            تقرير المبيعات الأسبوعية للمنتجات
                        <?php break; ?>

                        <?php case ('monthly'): ?>
                            تقرير المبيعات الشهرية للمنتجات
                        <?php break; ?>

                        <?php case ('yearly'): ?>
                            تقرير المبيعات السنوية للمنتجات
                        <?php break; ?>
                    <?php endswitch; ?>
                </h5>
                <form action="<?php echo e(route('salesReports.byProduct')); ?>" method="GET" class="mb-4">
                    <div class="row g-3">
                        <!-- فلتر المنتج -->
                        <div class="col-md-3">
                            <label class="form-label">المنتج</label>
                            <select name="product" class="form-control">
                                <option value="">جميع المنتجات</option>
                                <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($product->id); ?>"
                                        <?php echo e(request('product') == $product->id ? 'selected' : ''); ?>>
                                        <?php echo e($product->name); ?> (<?php echo e($product->code); ?>)
                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <!-- فلتر التصنيف -->
                        <div class="col-md-3">
                            <label class="form-label">تصنيف المنتج</label>
                            <select name="category" class="form-control">
                                <option value="">جميع التصنيفات</option>
                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($category->id); ?>"
                                        <?php echo e(request('category') == $category->id ? 'selected' : ''); ?>>
                                        <?php echo e($category->name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <!-- فلتر نوع الفاتورة -->
                        <div class="col-md-3">
                            <label class="form-label">نوع الفاتورة</label>
                            <select name="invoice_type" class="form-control">
                                <option value="">الكل</option>
                                <option value="1" <?php echo e(request('invoice_type') == '1' ? 'selected' : ''); ?>>مرتجع</option>
                                <option value="2" <?php echo e(request('invoice_type') == '2' ? 'selected' : ''); ?>>اشعار مدين
                                </option>
                                <option value="3" <?php echo e(request('invoice_type') == '3' ? 'selected' : ''); ?>>اشعار دائن
                                </option>
                            </select>
                        </div>

                        <!-- فلتر الفرع -->
                        <div class="col-md-3">
                            <label class="form-label">الفرع</label>
                            <select name="branch" class="form-control">
                                <option value="">جميع الفروع</option>
                                <?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($branch->id); ?>"
                                        <?php echo e(request('branch') == $branch->id ? 'selected' : ''); ?>>
                                        <?php echo e($branch->name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <!-- فلتر العميل -->
                        <div class="col-md-3">
                            <label class="form-label">العميل</label>
                            <select name="client" class="form-control">
                                <option value="">جميع العملاء</option>
                                <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($client->id); ?>"
                                        <?php echo e(request('client') == $client->id ? 'selected' : ''); ?>>
                                        <?php echo e($client->trade_name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <!-- فلتر فئة العميل -->
                        <div class="col-md-3">
                            <label class="form-label">فئة العميل</label>
                            <select name="client_category" class="form-control">
                                <option value="">جميع الفئات</option>
                                <?php $__currentLoopData = $client_categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($category->id); ?>"
                                        <?php echo e(request('client_category') == $category->id ? 'selected' : ''); ?>>
                                        <?php echo e($category->name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <!-- فلتر الموظف -->
                        <div class="col-md-3">
                            <label class="form-label">الموظف</label>
                            <select name="employee" class="form-control">
                                <option value="">جميع الموظفين</option>
                                <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($employee->id); ?>"
                                        <?php echo e(request('employee') == $employee->id ? 'selected' : ''); ?>>
                                        <?php echo e($employee->name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <!-- فلتر المخزن -->
                        <div class="col-md-3">
                            <label class="form-label">المخزن</label>
                            <select name="storehouse" class="form-control">
                                <option value="">جميع المخازن</option>
                                <?php $__currentLoopData = $storehouses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $storehouse): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($storehouse->id); ?>"
                                        <?php echo e(request('storehouse') == $storehouse->id ? 'selected' : ''); ?>>
                                        <?php echo e($storehouse->name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <!-- فلتر الفترة -->
                        <div class="col-md-3">
                            <label class="form-label">الفترة</label>
                            <select name="report_period" class="form-control">
                                <option value="">اختر الفترة</option>
                                <option value="daily" <?php echo e(request('report_period') == 'daily' ? 'selected' : ''); ?>>يومي
                                </option>
                                <option value="weekly" <?php echo e(request('report_period') == 'weekly' ? 'selected' : ''); ?>>أسبوعي
                                </option>
                                <option value="monthly" <?php echo e(request('report_period') == 'monthly' ? 'selected' : ''); ?>>شهري
                                </option>
                                <option value="yearly" <?php echo e(request('report_period') == 'yearly' ? 'selected' : ''); ?>>سنوي
                                </option>
                                <option value="custom" <?php echo e(request('report_period') == 'custom' ? 'selected' : ''); ?>>مخصص
                                </option>
                            </select>
                        </div>

                        <!-- فلتر من تاريخ (يظهر فقط عند اختيار مخصص) -->

                        <div class="col-md-3">
                            <label class="form-label">من تاريخ</label>
                            <input type="date" name="from_date" class="form-control"
                                value="<?php echo e($fromDate->format('Y-m-d')); ?>">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">إلى تاريخ</label>
                            <input type="date" name="to_date" class="form-control"
                                value="<?php echo e($toDate->format('Y-m-d')); ?>">
                        </div>

                        <!-- خيار عرض المسودات -->
                        <div class="col-md-3 align-self-end">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="add_draft" id="add_draft"
                                    value="1" <?php echo e(request('add_draft') ? 'checked' : ''); ?>>
                                <label class="form-check-label" for="add_draft">عرض المسودات</label>
                            </div>
                        </div>

                        <!-- أزرار التحكم -->
                        <div class="col-md-12 text-end mt-3">
                            <button type="submit" class="btn btn-primary me-2">
                                <i class="fas fa-filter me-1"></i> تطبيق الفلتر
                            </button>
                            <a href="<?php echo e(route('salesReports.byProduct')); ?>" class="btn btn-secondary me-2">
                                <i class="fas fa-redo me-1"></i> إعادة تعيين
                            </a>
                            <button type="submit" name="export" value="excel" class="btn btn-success me-2">
                                <i class="fas fa-file-excel me-1"></i> تصدير إكسل
                            </button>
                            <button type="submit" name="export" value="pdf" class="btn btn-danger">
                                <i class="fas fa-file-pdf me-1"></i> تصدير PDF
                            </button>
                        </div>
                    </div>
                </form>

                <script>
                    // عرض/إخفاء حقول التاريخ عند اختيار "مخصص"
                    document.querySelector('select[name="report_period"]').addEventListener('change', function() {
                        const isCustom = this.value === 'custom';
                        document.getElementById('from_date_container').style.display = isCustom ? 'block' : 'none';
                        document.getElementById('to_date_container').style.display = isCustom ? 'block' : 'none';
                    });
                </script>
            </div>
        </div>

        
        <?php if($productSales->count() > 0): ?>
            <div class="card mt-4">
                <div class="card-body">
                    
                    <ul class="nav nav-tabs" id="reportTabs">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#summary">الملخص</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#details">التفاصيل</a>
                        </li>
                        <li class="nav-item dropdown ms-auto">
                            <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#">خيارات</a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="#" onclick="window.print()">
                                    <i class="fas fa-print"></i> طباعة
                                </a>
                                <a class="dropdown-item" href="#" id="exportExcel">
                                    <i class="fas fa-file-excel"></i> تصدير Excel
                                </a>
                                <a class="dropdown-item" href="#" id="exportPDF">
                                    <i class="fas fa-file-pdf"></i> تصدير PDF
                                </a>
                            </div>
                        </li>
                    </ul>

                    <div class="tab-content mt-3">
                        
                        <div class="tab-pane fade show active" id="summary">
                            <div class="row">
                                <div class="col-md-6">
                                    <canvas id="quantityChart"></canvas>
                                </div>
                                <div class="col-md-6">
                                    <canvas id="amountChart"></canvas>
                                </div>
                            </div>

                            
                            <table class="table table-bordered mt-3">
                                <thead>
                                    <tr>
                                        <?php if($reportPeriod == 'daily'): ?>
                                            <th>التاريخ (يومي)</th>
                                        <?php elseif($reportPeriod == 'weekly'): ?>
                                            <th>الأسبوع</th>
                                        <?php elseif($reportPeriod == 'monthly'): ?>
                                            <th>الشهر</th>
                                        <?php elseif($reportPeriod == 'yearly'): ?>
                                            <th>السنة</th>
                                        <?php endif; ?>
                                        <th>رقم الفاتورة</th>
                                        <th>المعرف</th>
                                        <th>الاسم</th>
                                        <th>كود المنتج</th>
                                        <th>العميل</th>
                                        <th>نوع الفاتورة</th>
                                        <th>سعر الوحدة</th>
                                        <th>الكمية</th>
                                        <th>الخصم</th>
                                        <th>الإجمالي</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        // Adjust quantities and amounts for return invoices
                                        $adjustedSales = $productSales->map(function ($sale) {
                                            $sale->adjusted_quantity =
                                                $sale->invoice->type === 'return'
                                                    ? -abs($sale->quantity)
                                                    : $sale->quantity;
                                            $sale->adjusted_amount = $sale->adjusted_quantity * $sale->unit_price;
                                            return $sale;
                                        });

                                        $groupedSales = $adjustedSales->groupBy(function ($sale) use ($reportPeriod) {
                                            switch ($reportPeriod) {
                                                case 'daily':
                                                    return $sale->invoice->invoice_date->format('Y-m-d');
                                                case 'weekly':
                                                    return $sale->invoice->invoice_date->format('Y-W');
                                                case 'monthly':
                                                    return $sale->invoice->invoice_date->format('Y-m');
                                                case 'yearly':
                                                    return $sale->invoice->invoice_date->format('Y');
                                                default:
                                                    return $sale->invoice->invoice_date->format('Y-m-d');
                                            }
                                        });
                                    ?>

                                    <?php $__currentLoopData = $groupedSales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $period => $periodSales): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $periodTotalQuantity = $periodSales->sum('adjusted_quantity');
                                            $periodTotalDiscount = $periodSales->sum('discount_amount');
                                            $periodTotalAmount = $periodSales->sum('adjusted_amount');
                                        ?>

                                        
                                        <tr class="table-secondary">
                                            <td colspan="11" class="text-center">
                                                <?php if($reportPeriod == 'daily'): ?>
                                                    <strong><?php echo e(Carbon\Carbon::parse($period)->locale('ar')->isoFormat('LL')); ?></strong>
                                                <?php elseif($reportPeriod == 'weekly'): ?>
                                                    <strong>الأسبوع

                                                        <?php echo e($weekNumber = explode('-', $period)[1]); ?>


                                                        (<?php echo e(Carbon\Carbon::now()->setISODate(explode('-', $period)[0], $weekNumber)->startOfWeek()->format('Y-m-d')); ?>


                                                        إلى

                                                        <?php echo e(Carbon\Carbon::now()->setISODate(explode('-', $period)[0], $weekNumber)->endOfWeek()->format('Y-m-d')); ?>)
                                                    </strong>
                                                <?php elseif($reportPeriod == 'monthly'): ?>
                                                    <strong><?php echo e(Carbon\Carbon::parse($period . '-01')->locale('ar')->isoFormat('MMMM YYYY')); ?></strong>
                                                <?php elseif($reportPeriod == 'yearly'): ?>
                                                    <strong><?php echo e($period); ?></strong>
                                                <?php endif; ?>
                                            </td>
                                        </tr>

                                        
                                        <?php $__currentLoopData = $periodSales->groupBy('invoice_id'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoiceId => $invoiceSales): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                                $firstSale = $invoiceSales->first();
                                                $invoiceTotalQuantity = $invoiceSales->sum('adjusted_quantity');
                                                $invoiceTotalDiscount = $invoiceSales->sum('discount_amount');
                                                $invoiceTotalAmount = $invoiceSales->sum('adjusted_amount');
                                            ?>

                                            
                                            <tr class="table-info">
                                                <td colspan="11" class="text-center">
                                                    <strong>
                                                        رقم الفاتورة: <?php echo e($firstSale->invoice->code); ?> |
                                                        تاريخ الفاتورة:
                                                        <?php echo e($firstSale->invoice->invoice_date->format('Y-m-d')); ?>

                                                    </strong>
                                                </td>
                                            </tr>

                                            
                                            <?php $__currentLoopData = $invoiceSales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sale): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr <?php if($sale->invoice->type === 'return'): ?> class="table-danger" <?php endif; ?>>
                                                    <?php if($reportPeriod == 'daily'): ?>
                                                        <td><?php echo e(Carbon\Carbon::parse($period)->format('Y-m-d')); ?></td>
                                                    <?php elseif($reportPeriod == 'weekly'): ?>
                                                    <?php
                                                    [$year, $week] = explode('-', $period);
                                                    $date = \Carbon\Carbon::now()->setISODate($year, $week);
                                                ?>

                                                <td>
                                                    الأسبوع <?php echo e($date->weekOfYear); ?>

                                                </td>

                                                    <?php elseif($reportPeriod == 'monthly'): ?>
                                                        <td><?php echo e(Carbon\Carbon::parse($period . '-01')->format('Y-m')); ?></td>
                                                    <?php elseif($reportPeriod == 'yearly'): ?>
                                                        <td><?php echo e($period); ?></td>
                                                    <?php endif; ?>
                                                    <td><?php echo e($sale->invoice->code); ?></td>
                                                    <td><?php echo e($sale->product->id); ?></td>
                                                    <td><?php echo e($sale->product->name); ?></td>
                                                    <td><?php echo e($sale->product->code); ?></td>
                                                    <td><?php echo e($sale->invoice->client->trade_name); ?></td>
                                                    <td>
                                                        <?php if($sale->invoice->type === 'normal'): ?>
                                                            فاتورة
                                                        <?php elseif($sale->invoice->type === 'returned'): ?>
                                                            مرتجع
                                                        <?php elseif($sale->invoice->type === 'debit_note'): ?>
                                                            اشعار مدين
                                                        <?php elseif($sale->invoice->type === 'credit_note'): ?>
                                                            اشعار دائن
                                                        <?php endif; ?>
                                                    </td>
                                                    <td><?php echo e(number_format($sale->unit_price, 2)); ?></td>
                                                    <td><?php echo e($sale->adjusted_quantity); ?></td>
                                                    <td><?php echo e(number_format($sale->discount_amount ?? 0, 2)); ?></td>
                                                    <td><?php echo e(number_format($sale->adjusted_amount, 2)); ?></td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                            
                                            <tr class="table-warning">
                                                <td colspan="7" class="text-end"><strong>مجموع الفاتورة</strong></td>
                                                <td><?php echo e(number_format($invoiceTotalQuantity, 2)); ?></td>
                                                <td><?php echo e(number_format($invoiceTotalDiscount, 2)); ?></td>
                                                <td><?php echo e(number_format($invoiceTotalAmount, 2)); ?></td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                        
                                        <tr class="table-success">
                                            <td colspan="7" class="text-end"><strong>مجموع الفترة</strong></td>
                                            <td><?php echo e(number_format($periodTotalQuantity, 2)); ?></td>
                                            <td><?php echo e(number_format($periodTotalDiscount, 2)); ?></td>
                                            <td><?php echo e(number_format($periodTotalAmount, 2)); ?></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                                <tfoot>
                                    <?php
                                        $grandTotalQuantity = $adjustedSales->sum('adjusted_quantity');
                                        $grandTotalDiscount = $adjustedSales->sum('discount_amount');
                                        $grandTotalAmount = $adjustedSales->sum('adjusted_amount');
                                    ?>
                                    <tr class="table-primary">
                                        <td colspan="7" class="text-end"><strong>المجموع الكلي</strong></td>
                                        <td><?php echo e(number_format($grandTotalQuantity, 2)); ?></td>
                                        <td><?php echo e(number_format($grandTotalDiscount, 2)); ?></td>
                                        <td><?php echo e(number_format($grandTotalAmount, 2)); ?></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="alert alert-info mt-4">
                لا توجد بيانات متاحة للعرض
            </div>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.5/xlsx.full.min.js"></script>
    <script>
        // الرسومات البيانية (كما هي سابقًا)
        const quantityCtx = document.getElementById('quantityChart').getContext('2d');
        new Chart(quantityCtx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($chartData['labels'], 15, 512) ?>,
                datasets: [{
                    label: 'الكمية',
                    data: <?php echo json_encode($chartData['quantities'], 15, 512) ?>,
                    backgroundColor: 'rgba(54, 162, 235, 0.6)'
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'كمية المبيعات حسب المنتج'
                    }
                }
            }
        });

        const amountCtx = document.getElementById('amountChart').getContext('2d');
        new Chart(amountCtx, {
            type: 'pie',
            data: {
                labels: <?php echo json_encode($chartData['labels'], 15, 512) ?>,
                datasets: [{
                    label: 'المبلغ',
                    data: <?php echo json_encode($chartData['amounts'], 15, 512) ?>,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.6)',
                        'rgba(54, 162, 235, 0.6)',
                        'rgba(255, 206, 86, 0.6)',
                        'rgba(75, 192, 192, 0.6)'
                    ]
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'إجمالي المبيعات حسب المنتج'
                    }
                }
            }
        });

        // تصدير Excel
        document.getElementById('exportExcel').addEventListener('click', function() {
            // العثور على جدول التقرير
            const table = document.querySelector('#summary table');

            // إنشاء كتاب Excel
            const wb = XLSX.utils.table_to_book(table, {
                raw: true,
                cellDates: true
            });

            // توليد اسم الملف مع التاريخ الحالي
            const today = new Date();
            const fileName =
                `تقرير_مبيعات_المنتجات_${today.getFullYear()}-${today.getMonth() + 1}-${today.getDate()}.xlsx`;

            // تصدير الكتاب
            XLSX.writeFile(wb, fileName);
        });

        // تصدير PDF (يمكنك استبدال هذا بمكتبة PDF مناسبة)
        document.getElementById('exportPDF').addEventListener('click', function() {
            window.print(); // طباعة الصفحة كـ PDF
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\fawtramsmart\fawtra\resources\views/reports/sals/salesRport/by_Product.blade.php ENDPATH**/ ?>