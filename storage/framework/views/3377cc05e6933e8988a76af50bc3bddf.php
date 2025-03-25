<?php $__env->startSection('title'); ?>
    اضافة عرض سعر شراء
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">اضافة عرض سعر شراء</h2>
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
        <form class="form" action="<?php echo e(route('Quotations.store')); ?>" method="post" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
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

            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <div>
                            <label>الحقول التي عليها علامة <span style="color: red">*</span> الزامية</label>
                        </div>
                        <div>
                            <a href="" class="btn btn-outline-danger">
                                <i class="fa fa-ban"></i>الغاء
                            </a>
                            <button type="submit" class="btn btn-outline-primary">
                                <i class="fa fa-save"></i>حفظ
                            </button>
                        </div>
                    </div>
                </div>
            </div>


            <div class="card" style="max-width: 90%; margin: 0 auto;">
                <h1>
                </h1>
                <div class="card-body">
                    <div class="form-body row">

                        <div class="form-group col-md-4">
                            <label for="feedback1" class=""> الكود </label>
                            <input type="text" id="feedback1" class="form-control" placeholder="الكود" name="code" value="<?php echo e(str_pad((\App\Models\PurchaseQuotation::max('id') ?? 0) + 1, 5, '0', STR_PAD_LEFT)); ?>">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="feedback1" class=""> تاريخ الطلب </label>
                            <input type="date" id="feedback1" class="form-control" name="order_date">

                        </div>
                        <div class="form-group col-md-4">
                            <label for="feedback1" class=""> تاريخ الاستحقاق </label>
                            <input type="date" id="feedback1" class="form-control" name="due_date">

                        </div>
                    </div>
                    <div class="form-body row">
                        <div class="form-group col-md-12">
                            <label for="supplier_id" class=""> اختر الموردين <span style="color: red">*</span></label>
                            <select id="supplier_id" class="form-control select2" name="supplier_id[]" multiple="multiple" required>
                                <?php $__currentLoopData = $suppliers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $supplier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($supplier->id); ?>"
                                        <?php echo e(in_array($supplier->id, old('supplier_id', [])) ? 'selected' : ''); ?>>
                                        <?php echo e($supplier->trade_name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['supplier_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="text-danger"><?php echo e($message); ?></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>


                </div>

            </div>


    </div>
    <div class="card" style="max-width: 90%; margin: 0 auto; margin-top: 20px">
        <div class="card-body">






            <div class="mt-4">
                <h6>المنتج <span style="color: red">*</span></h6>
                <div class="table-responsive">
                    <table class="table" id="products-table">
                        <thead style="background: #e9ecef">
                            <tr>
                                <th style="width: 50px"></th>
                                <th>بند</th>
                                <th>الكمية</th>
                                <th style="width: 50px"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- الصف الأول الافتراضي -->
                            <tr class="product-row">
                                <td class="align-middle text-center">
                                    <i class="fas fa-grip-vertical text-muted"></i>
                                </td>
                                <td>
                                    <div class="position-relative">
                                        <select class="form-control item-select" name="product_details[0][product_id]" required>
                                            <option value="">اختر البند</option>
                                            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($product->id); ?>"><?php echo e($product->name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </td>
                                <td>
                                    <input type="number" class="form-control amount-input" placeholder="ادخل كمية"
                                        name="product_details[0][quantity]" min="1" required>
                                </td>
                                <td class="align-middle text-center">
                                    <i class="fas fa-minus-circle text-danger remove-row" style="cursor: pointer;"></i>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <button type="button" class="btn btn-success" onclick="addNewRow()">
                        <i class="fas fa-plus"></i> إضافة منتج
                    </button>
                </div>
            </div>



        </div>

    </div>



    <div class="card" style="max-width: 90%; margin: 0 auto; margin-top: 20px">
        <div class="card-body">
            <!-- الملاحظات -->
            <div class="mt-4">
                <h6 class="mb-2">الملاحظات</h6>
                <textarea class="form-control" name="notes" rows="4" placeholder="اكتب ملاحظاتك هنا..."></textarea>
            </div>
            <div class="mt-4">
                <div class="form-group">
                    <label for="attachments">المرفقات</label>
                    <input type="file" name="attachments" id="attachments" class="d-none">
                    <div class="upload-area border rounded p-3 text-center position-relative"
                        onclick="document.getElementById('attachments').click()">
                        <div class="d-flex align-items-center justify-content-center gap-2">
                            <i class="fas fa-cloud-upload-alt text-primary"></i>
                            <span class="text-primary">اضغط هنا</span>
                            <span>أو</span>
                            <span class="text-primary">اختر من جهازك</span>
                        </div>
                        <div class="position-absolute end-0 top-50 translate-middle-y me-3">
                            <i class="fas fa-file-alt fs-3 text-secondary"></i>
                        </div>
                    </div>
                </div>
            </div>

        </div>


        </form>
    </div>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script>
        let rowCounter = 1;

        function addNewRow() {
            const tbody = document.querySelector('#products-table tbody');
            const newRow = document.createElement('tr');
            newRow.className = 'product-row';

            newRow.innerHTML = `
                <td class="align-middle text-center">
                    <i class="fas fa-grip-vertical text-muted"></i>
                </td>
                <td>
                    <div class="position-relative">
                        <select class="form-control item-select" name="product_details[${rowCounter}][product_id]" required>
                            <option value="">اختر البند</option>
                            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($product->id); ?>"><?php echo e($product->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </td>
                <td>
                    <input type="number" class="form-control amount-input" placeholder="ادخل كمية"
                        name="product_details[${rowCounter}][quantity]" min="1" required>
                </td>
                <td class="align-middle text-center">
                    <i class="fas fa-minus-circle text-danger remove-row" onclick="removeRow(this)" style="cursor: pointer;"></i>
                </td>
            `;

            tbody.appendChild(newRow);
            rowCounter++;
        }

        function removeRow(element) {
            const tbody = document.querySelector('#products-table tbody');
            if (tbody.querySelectorAll('.product-row').length > 1) {
                element.closest('.product-row').remove();
            } else {
                alert('يجب أن يكون هناك منتج واحد على الأقل');
            }
        }

        // إضافة مستمع لأحداث النقر على أزرار الحذف الموجودة
        document.querySelectorAll('.remove-row').forEach(button => {
            button.onclick = function() {
                removeRow(this);
            };
        });

        // التحقق من النموذج قبل الإرسال
        document.getElementById('quotationForm').onsubmit = function(e) {
            const rows = document.querySelectorAll('.product-row');
            let isValid = true;

            rows.forEach(row => {
                const productId = row.querySelector('.item-select').value;
                const quantity = row.querySelector('.amount-input').value;

                if (!productId || !quantity) {
                    isValid = false;
                }
            });

            if (!isValid) {
                e.preventDefault();
                alert('الرجاء ملء جميع حقول المنتجات والكميات');
            }
        };
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/sehohoqm/hitstest.sehoool.com/resources/views/Purchases/Quotations/create.blade.php ENDPATH**/ ?>