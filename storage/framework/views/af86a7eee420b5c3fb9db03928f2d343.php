<?php $__env->startSection('title'); ?>
    تقرير أرباح المنتجات
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>


        .report-container {
            background-color: #f5f7fb;
            padding: 20px;
            border-radius: 10px;
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            border-radius: 10px 10px 0 0 !important;
            padding: 15px 20px;
        }

        .filter-card {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .filter-label {
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 8px;
        }

        .btn-filter {
            background-color: var(--primary-color);
            color: white;
            border-radius: 6px;
            padding: 8px 20px;
        }

        .btn-filter:hover {
            background-color: var(--secondary-color);
            color: white;
        }

        .table-profits {
            border-collapse: separate;
            border-spacing: 0;
            width: 100%;
        }

        .table-profits thead th {
            background-color: #f1f3f9;
            color: var(--dark-color);
            font-weight: 600;
            border: none;
            padding: 12px 15px;
        }

        .table-profits tbody td {
            padding: 12px 15px;
            border-bottom: 1px solid #f1f3f9;
            vertical-align: middle;
        }

        .table-profits tbody tr:hover {
            background-color: rgba(67, 97, 238, 0.05);
        }

        .profit-positive {
            color: #2ecc71;
            font-weight: 600;
        }

        .profit-negative {
            color: #e74c3c;
            font-weight: 600;
        }

        .insights-badge {
            font-size: 0.9rem;
            padding: 8px 12px;
            border-radius: 6px;
            background: linear-gradient(135deg, #4cc9f0, #4895ef);
        }

        .summary-card {
            background: white;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            border-left: 4px solid var(--primary-color);
        }

        .summary-title {
            font-size: 0.9rem;
            color: #6c757d;
            margin-bottom: 5px;
        }

        .summary-value {
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--dark-color);
        }

        .summary-icon {
            font-size: 1.8rem;
            color: var(--primary-color);
            margin-bottom: 10px;
        }

        .select2-container--default .select2-selection--multiple {
            border: 1px solid #ced4da;
            border-radius: 6px;
        }

        .no-data {
            text-align: center;
            padding: 40px;
            background-color: #f8f9fa;
            border-radius: 8px;
        }

        .no-data i {
            font-size: 3rem;
            color: #adb5bd;
            margin-bottom: 15px;
        }

        .chart-container {
            height: 300px;
            margin-top: 20px;
        }

        @media (max-width: 768px) {
            .card-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .insights-badge {
                margin-top: 10px;
                margin-left: 0;
            }
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid py-4">
        <div class="report-container">
            <!-- Header Section -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="page-header d-flex justify-content-between align-items-center">
                        <h2 class="mb-0">
                            <i class="fas fa-chart-pie me-2"></i>
                            تقرير أرباح المنتجات
                        </h2>
                        <div class="d-flex">
                            <button id="exportExcel" class="btn btn-success me-2">
                                <i class="fas fa-file-excel me-1"></i> تصدير إكسل
                            </button>

                        </div>
                    </div>

                </div>
            </div>

            <!-- Summary Cards -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="summary-card">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="summary-title">إجمالي الربح</div>
                                <div class="summary-value text-success"><?php echo e(number_format($profitsReport->sum('profit'), 2)); ?> ر.س</div>
                            </div>
                            <i class="fas fa-coins summary-icon"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="summary-card">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="summary-title">إجمالي المبيعات</div>
                                <div class="summary-value"><?php echo e(number_format($profitsReport->sum('total_value'), 2)); ?> ر.س</div>
                            </div>
                            <i class="fas fa-cash-register summary-icon"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="summary-card">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="summary-title">إجمالي الكمية</div>
                                <div class="summary-value"><?php echo e(number_format($profitsReport->sum('total_quantity'), 2)); ?></div>
                            </div>
                            <i class="fas fa-boxes summary-icon"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="summary-card">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="summary-title">متوسط نسبة الربح</div>
                                <div class="summary-value text-success">
                                    <?php echo e(number_format($profitsReport->sum('total_value') > 0 ? ($profitsReport->sum('profit') / $profitsReport->sum('total_value')) * 100 : 0, 2)); ?>%
                                </div>
                            </div>
                            <i class="fas fa-percentage summary-icon"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filters Section -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="fas fa-filter me-2"></i>
                                تصفية النتائج
                            </h5>
                        </div>
                        <div class="card-body">
                            <form method="GET" action="<?php echo e(route('salesReports.profits')); ?>" id="profitsFilterForm">
                                <div class="row">
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label filter-label">
                                            <i class="fas fa-calendar-alt me-2"></i>الفترة من
                                        </label>
                                        <input type="date" name="from_date" class="form-control" value="<?php echo e($fromDate); ?>">
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label filter-label">
                                            <i class="fas fa-calendar-alt me-2"></i>الفترة إلى
                                        </label>
                                        <input type="date" name="to_date" class="form-control" value="<?php echo e($toDate); ?>">
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label filter-label">
                                            <i class="fas fa-box me-2"></i>المنتجات
                                        </label>
                                        <select name="products[]" class="form-control select2" multiple>
                                            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($product->id); ?>" <?php echo e(in_array($product->id, request('products', [])) ? 'selected' : ''); ?>>
                                                    <?php echo e($product->name); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label filter-label">
                                            <i class="fas fa-tags me-2"></i>التصنيفات
                                        </label>
                                        <select name="categories[]" class="form-control select2" multiple>
                                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($category->id); ?>" <?php echo e(in_array($category->id, request('categories', [])) ? 'selected' : ''); ?>>
                                                    <?php echo e($category->name); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label filter-label">
                                            <i class="fas fa-trademark me-2"></i>الماركات
                                        </label>
                                        <select name="brands[]" class="form-control select2" multiple>
                                            <?php $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($brand); ?>" <?php echo e(in_array($brand, request('brands', [])) ? 'selected' : ''); ?>>
                                                    <?php echo e($brand); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label filter-label">
                                            <i class="fas fa-store me-2"></i>الفروع
                                        </label>
                                        <select name="branches[]" class="form-control select2" multiple>
                                            <?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($branch->id); ?>" <?php echo e(in_array($branch->id, request('branches', [])) ? 'selected' : ''); ?>>
                                                    <?php echo e($branch->name); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6 d-flex align-items-end justify-content-end">
                                        <div>
                                            <button type="submit" class="btn btn-success me-2">
                                                <i class="fas fa-filter me-1"></i> تطبيق الفلتر
                                            </button>
                                            <a href="<?php echo e(route('salesReports.profits')); ?>" class="btn btn-outline-secondary" id="resetFilters">
                                                <i class="fas fa-redo me-1"></i> إعادة تعيين
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Results Section -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">
                                <i class="fas fa-table me-2"></i>
                                النتائج
                            </h5>
                            <div class="badge bg-primary rounded-pill">
                                <?php echo e($profitsReport->count()); ?> منتج
                            </div>
                        </div>
                        <div class="card-body">
                            <?php if($profitsReport->count() > 0): ?>
                                <div class="table-responsive">
                                    <table class="table table-profits" id="profitsTable">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>اسم المنتج</th>
                                                <th>التصنيف</th>
                                                <th>الماركة</th>
                                                <th>الكمية</th>
                                                <th>إجمالي المبيعات</th>
                                                <th>سعر الشراء</th>
                                                <th>سعر البيع</th>
                                                <th>إجمالي التكلفة</th>
                                                <th>صافي الربح</th>
                                                <th>نسبة الربح</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $__currentLoopData = $profitsReport; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><?php echo e($index + 1); ?></td>
                                                    <td>
                                                        <span class="fw-semibold"><?php echo e($product['name']); ?></span>
                                                    </td>
                                                    <td><?php echo e($product['category_name'] ?? 'غير محدد'); ?></td>
                                                    <td><?php echo e($product['brand'] ?? 'غير محدد'); ?></td>
                                                    <td><?php echo e(number_format($product['total_quantity'], 2)); ?></td>
                                                    <td><?php echo e(number_format($product['total_value'], 2)); ?> ر.س</td>
                                                    <td><?php echo e(number_format($product['purchase_price'], 2)); ?> ر.س</td>
                                                    <td><?php echo e(number_format($product['sale_price'], 2)); ?> ر.س</td>
                                                    <td><?php echo e(number_format($product['total_cost'], 2)); ?> ر.س</td>
                                                    <td class="<?php echo e($product['profit'] >= 0 ? 'profit-positive' : 'profit-negative'); ?>">
                                                        <?php echo e(number_format($product['profit'], 2)); ?> ر.س
                                                    </td>
                                                    <td class="<?php echo e($product['profit_percentage'] >= 0 ? 'profit-positive' : 'profit-negative'); ?>">
                                                        <?php echo e(number_format($product['profit_percentage'], 2)); ?>%
                                                    </td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                        <tfoot class="table-group-divider">
                                            <tr>
                                                <th colspan="4" class="text-end">الإجمالي</th>
                                                <th><?php echo e(number_format($profitsReport->sum('total_quantity'), 2)); ?></th>
                                                <th><?php echo e(number_format($profitsReport->sum('total_value'), 2)); ?> ر.س</th>
                                                <th colspan="2"></th>
                                                <th><?php echo e(number_format($profitsReport->sum('total_cost'), 2)); ?> ر.س</th>
                                                <th class="<?php echo e($profitsReport->sum('profit') >= 0 ? 'profit-positive' : 'profit-negative'); ?>">
                                                    <?php echo e(number_format($profitsReport->sum('profit'), 2)); ?> ر.س
                                                </th>
                                                <th class="<?php echo e($profitsReport->sum('profit') >= 0 ? 'profit-positive' : 'profit-negative'); ?>">
                                                    <?php echo e(number_format($profitsReport->sum('total_value') > 0 ? ($profitsReport->sum('profit') / $profitsReport->sum('total_value')) * 100 : 0, 2)); ?>%
                                                </th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            <?php else: ?>
                                <div class="no-data">
                                    <i class="fas fa-database"></i>
                                    <h5>لا توجد بيانات متاحة</h5>
                                    <p class="text-muted">لم يتم العثور على أي بيانات تتناسب مع معايير الفلترة المحددة</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.5/xlsx.full.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize Select2

            // Set selected values for filters
            <?php if(request('products')): ?>
                $('select[name="products[]"]').val(<?php echo json_encode(request('products'), 15, 512) ?>).trigger('change');
            <?php endif; ?>

            <?php if(request('categories')): ?>
                $('select[name="categories[]"]').val(<?php echo json_encode(request('categories'), 15, 512) ?>).trigger('change');
            <?php endif; ?>

            <?php if(request('brands')): ?>
                $('select[name="brands[]"]').val(<?php echo json_encode(request('brands'), 15, 512) ?>).trigger('change');
            <?php endif; ?>

            <?php if(request('branches')): ?>
                $('select[name="branches[]"]').val(<?php echo json_encode(request('branches'), 15, 512) ?>).trigger('change');
            <?php endif; ?>

            // Excel Export
            $('#exportExcel').on('click', function() {
                const table = document.getElementById('profitsTable');
                const wb = XLSX.utils.table_to_book(table, {
                    sheet: "تقرير الأرباح",
                    raw: true
                });

                const today = new Date();
                const fileName = `تقرير_أرباح_المنتجات_${today.getFullYear()}-${today.getMonth()+1}-${today.getDate()}.xlsx`;

                XLSX.writeFile(wb, fileName);
            });

            // Reset filters
            $('#resetFilters').on('click', function() {
                $('.select2').val(null).trigger('change');
                $('input[type="date"]').val('');
            });

            // Tooltips
            $('[data-bs-toggle="tooltip"]').tooltip();
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\fawtramsmart\fawtra\resources\views/reports/sals/proudect_proifd/proudect_proifd.blade.php ENDPATH**/ ?>