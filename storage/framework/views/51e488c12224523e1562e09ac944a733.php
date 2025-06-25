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
                            <li class="breadcrumb-item active">تعديل
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="content-body">
        <div class="container-fluid">
            <?php if($errors->any()): ?>
                <div class="alert alert-danger">
                    <ul>
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>
            <?php if(session('error')): ?>
                <div class="alert alert-danger">
                    <?php echo e(session('error')); ?>

                </div>
            <?php endif; ?>

            <form class="form-horizontal" action="<?php echo e(route('store_permits_management.update', $permit->id)); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <div>
                                <label>الحقول التي عليها علامة <span style="color: red">*</span> الزامية</label>
                            </div>

                            <div>
                                <a href="<?php echo e(route('store_permits_management.index')); ?>" class="btn btn-outline-danger">
                                    <i class="fa fa-ban"></i>الغاء
                                </a>
                                <button type="submit" class="btn btn-outline-primary">
                                    <i class="fa fa-save"></i>تحديث
                                </button>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <h4 class="card-title">الأذون المخزنية</h4>
                        </div>

                        <div class="card-body">
                            <div class="form-body row">
                                <div class="form-group col-md-2 mt-1">
                                    <div class="vs-checkbox-con vs-checkbox-primary">
                                        <input type="checkbox" name="permission_type" value="1" <?php echo e($permit->permission_type == 1 ? 'checked' : ''); ?> disabled>
                                        <span class="vs-checkbox">
                                            <span class="vs-checkbox--check">
                                                <i class="vs-icon feather icon-check"></i>
                                            </span>
                                        </span>
                                        <span class="">إذن إضافة مخزن</span>
                                    </div>
                                </div>

                                <input type="hidden" name="permission_type" value="1">

                                <div class="form-group col-md-4">
                                    <label for="">التاريخ</label>
                                    <input type="datetime-local" id="datetime" class="form-control" name="permission_date" value="<?php echo e($permit->permission_date); ?>">
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="">المحزن</label>
                                    <select class="form-control" name="store_houses_id">
                                        <?php $__currentLoopData = $storeHouses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $storeHouse): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($storeHouse->id); ?>" <?php echo e($permit->store_houses_id == $storeHouse->id ? 'selected' : ''); ?>><?php echo e($storeHouse->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="">الحساب الفرعي</label>
                                    <select class="form-control" id="basicSelect" name="sub_account">
                                        <option value="1" <?php echo e($permit->sub_account == 1 ? 'selected' : ''); ?>>الحساب الفرعي 1</option>
                                        <option value="2" <?php echo e($permit->sub_account == 2 ? 'selected' : ''); ?>>الحساب الفرعي 2</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                    <label>رقم <span style="color: red">*</span></label>
                                    <input type="number" class="form-control" name="number" value="<?php echo e($permit->number); ?>">
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="feedback2">الملاحظات </label>
                                    <textarea class="form-control" rows="2" placeholder="ادخل ملاحظاتك هنا" name="details"><?php echo e($permit->details); ?></textarea>
                                </div>

                                <div class="form-group col-md-6">
                                    <label>المرفقات</label>
                                    <input type="file" class="form-control" name="attachments">
                                    <?php if($permit->attachments): ?>
                                        <a href="<?php echo e(asset('assets/uploads/warehouse/' . $permit->attachments)); ?>" target="_blank">عرض المرفقات الحالية</a>
                                    <?php endif; ?>
                                </div>

                                <div class="form-group col-md-12">
                                    <table class="table table-striped" id="itemsTable">
                                        <thead class="table-light">
                                            <tr>
                                                <th>البنود</th>
                                                <th>سعر الوحدة</th>
                                                <th>الكمية</th>
                                                <th>رصيد المخزن قبل</th>
                                                <th>رصيد المخزن بعد</th>
                                                <th>الإجمالي</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $__currentLoopData = App\Models\WarehousePermitsProducts::where('warehouse_permits_id', $permit->id)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td>
                                                        <select name="product_id[]" class="form-control select2 product-select">
                                                            <option value="" disabled>-- اختر البند --</option>
                                                            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <option value="<?php echo e($product->id); ?>" <?php echo e($item->product_id == $product->id ? 'selected' : ''); ?> data-price="<?php echo e($product->sale_price); ?>"><?php echo e($product->name); ?></option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </select>
                                                    </td>
                                                    <td><input type="number" name="unit_price[]" class="form-control unit-price" value="<?php echo e($item->unit_price); ?>" readonly></td>
                                                    <td><input type="number" name="quantity[]" class="form-control quantity" value="<?php echo e($item->quantity); ?>" min="1"></td>
                                                    <td>0.00</td>
                                                    <td>0.00</td>
                                                    <td><input type="number" name="total[]" class="form-control total" value="<?php echo e($item->total); ?>" readonly></td>
                                                    <td>
                                                        <button type="button" class="btn btn-outline-danger btn-sm removeRow"><i class="fa fa-minus"></i></button>
                                                    </td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                    <hr>
                                    <div class="d-flex justify-content-between mt-2">
                                        <button type="button" class="btn btn-outline-success btn-sm" id="addRow"><i class="fa fa-plus"></i> إضافة</button>
                                        <strong style="margin-left: 13rem;"><small class="text-muted">الإجمالي الكلي : </small><span class="grand-total"><?php echo e($permit->grand_total); ?></span></strong>
                                        <input type="hidden" name="grand_total" value="">
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const input = document.getElementById('datetime');
            if (!input.value) {
                const now = new Date();
                now.setHours(now.getUTCHours() + 5);
                const formattedDateTime = now.toISOString().slice(0, 16);
                input.value = formattedDateTime;
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const itemsTable = document.getElementById('itemsTable').querySelector('tbody');
            const addRowButton = document.getElementById('addRow');

            // Function to calculate total for a row
            function calculateTotal(row) {
                const unitPrice = parseFloat(row.querySelector('.unit-price').value) || 0;
                const quantity = parseFloat(row.querySelector('.quantity').value) || 0;
                const total = unitPrice * quantity;
                row.querySelector('.total').value = total.toFixed(2);
                updateGrandTotal();
            }

            // Function to update grand total
            function updateGrandTotal() {
                let grandTotal = 0;
                document.querySelectorAll('.total').forEach(totalInput => {
                    grandTotal += parseFloat(totalInput.value) || 0;
                });
                document.querySelector('.grand-total').textContent = grandTotal.toFixed(2);
                document.querySelector('input[name="grand_total"]').value = grandTotal.toFixed(2);
            }

            // Function to attach event listeners to a row
            function attachRowEvents(row) {
                const productSelect = row.querySelector('.product-select');
                const quantityInput = row.querySelector('.quantity');

                if (productSelect) {
                    productSelect.addEventListener('change', function () {
                        const selectedOption = productSelect.options[productSelect.selectedIndex];
                        const unitPrice = selectedOption.getAttribute('data-price');
                        row.querySelector('.unit-price').value = unitPrice;
                        calculateTotal(row);
                    });
                }

                if (quantityInput) {
                    quantityInput.addEventListener('input', function () {
                        calculateTotal(row);
                    });
                }
            }

            // Attach events to existing rows
            document.querySelectorAll('#itemsTable tbody tr').forEach(row => {
                attachRowEvents(row);
            });

            // Add Row
            addRowButton.addEventListener('click', function (e) {
                e.preventDefault();

                const newRow = document.createElement('tr');
                newRow.innerHTML = `
                    <td>
                        <select name="product_id[]" class="form-control select2 product-select">
                            <option value="" disabled selected>-- اختر البند --</option>
                            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($product->id); ?>" data-price="<?php echo e($product->sale_price); ?>"><?php echo e($product->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </td>
                    <td><input type="number" name="unit_price[]" class="form-control unit-price" readonly></td>
                    <td><input type="number" name="quantity[]" class="form-control quantity" value="1" min="1"></td>
                    <td>0.00</td>
                    <td>0.00</td>
                    <td><input type="number" name="total[]" class="form-control total" readonly></td>
                    <td>
                        <button type="button" class="btn btn-outline-danger btn-sm removeRow"><i class="fa fa-minus"></i></button>
                    </td>
                `;

                itemsTable.appendChild(newRow);
                attachRowEvents(newRow); // Attach events to the new row
            });

            // Remove Row
            itemsTable.addEventListener('click', function (e) {
                if (e.target.classList.contains('removeRow')) {
                    const row = e.target.closest('tr');
                    row.remove();
                    updateGrandTotal();
                }
            });
        });
    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\fawtramsmart\fawtra\resources\views/stock/store_permits_management/edit.blade.php ENDPATH**/ ?>