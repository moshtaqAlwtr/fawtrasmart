<?php $__env->startSection('title'); ?>
    انشاء عرض سعر مشتريات
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0"></h2>
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
        <form id="invoice-form" action="<?php echo e(route('pricesPurchase.store')); ?>" method="post">
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
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">

                                <div class="row">
                                    <div class="col-12">

                                    </div>
                                    <div class="col-12">
                                        <div class="form-group row">
                                            <div class="col-md-2">
                                                <span>المورد :</span>
                                            </div>
                                            <div class="col-md-6">
                                                <select class="form-control select2" id="clientSelect" name="supplier_id"
                                                    required>
                                                    <option value="">اختر المورد</option>
                                                    <?php $__currentLoopData = $suppliers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $supplier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($supplier->id); ?>"><?php echo e($supplier->trade_name); ?>

                                                        </option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <a href="<?php echo e(route('SupplierManagement.create')); ?>" type="button"
                                                    class="btn btn-primary mr-1 mb-1 waves-effect waves-light">
                                                    <i class="fa fa-user-plus"></i>جديد
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">

                                <div class="row add_item">
                                    <div class="col-12">
                                        <div class="form-group row">
                                            <div class="col-md-3">
                                                <span>رقم عرض الشراء:</span>
                                            </div>
                                            <div class="col-md-8">
                                                <label class="form-control"></label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group row">
                                            <div class="col-md-3">
                                                <span>التاريخ:</span>
                                            </div>
                                            <div class="col-md-8">
                                                <input class="form-control" type="date" name="date">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group row">
                                            <div class="col-md-3">
                                                <span>صالح حتى :</span>
                                            </div>
                                            <div class="col-md-6">
                                                <input class="form-control" type="text" name="valid_days">
                                            </div>
                                            <div class="col-md-2">
                                                <span class="form-control-plaintext">أيام</span>
                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-12">
                                        <div class="form-group row">
                                            <div class="col-md-3">
                                                <span>الحساب الفرعي :</span>
                                            </div>
                                            <div class="col-md-8">
                                                <select name="account_id" id="" class="form-control">
                                                    <option value=""> اختر الحساب </option>
                                                    <?php $__currentLoopData = $accounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($account->id); ?>"><?php echo e($account->name); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>


                                        </div>

                                    </div>

                                    <div class="col-12">
                                        <div class="form-group row">
                                            <div class="col-md-3">
                                                <input class="form-control" type="text" placeholder="عنوان إضافي">
                                            </div>
                                            <div class="col-md-8">
                                                <div class="input-group">
                                                    <input class="form-control" type="text" placeholder="بيانات إضافية">
                                                    <div class="input-group-append">
                                                        <button type="button"
                                                            class="btn btn-outline-success waves-effect waves-light addeventmore">
                                                            <i class="fa fa-plus-circle"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <input type="hidden" id="products-data" value="<?php echo e(json_encode($items)); ?>">
                        <div class="table-responsive">
                            <table class="table" id="items-table">
                                <thead>
                                    <tr>
                                        <th>المنتج</th>
                                        <th>الوصف</th>
                                        <th>الكمية</th>
                                        <th>السعر</th>
                                        <th>الخصم</th>
                                        <th>الضريبة 1</th>
                                        <th>الضريبة 2</th>
                                        <th>المجموع</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="item-row">
                                        <td style="width:18%">
                                            <select name="items[0][product_id]"
                                                class="form-control product-select select2">
                                                <option value="">اختر المنتج</option>
                                                <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($item->id); ?>" data-price="<?php echo e($item->price); ?>">
                                                        <?php echo e($item->name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" name="items[0][description]"
                                                class="form-control item-description">
                                        </td>
                                        <td>
                                            <input type="number" name="items[0][quantity]" class="form-control quantity"
                                                value="1" min="1" required>
                                        </td>
                                        <td>
                                            <input type="number" name="items[0][unit_price]" class="form-control price"
                                                step="0.01"  required>
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <input type="number" name="items[0][discount]"
                                                    class="form-control discount-amount" value="0" min="0"
                                                    step="0.01">
                                                <input type="number" name="items[0][discount_percentage]"
                                                    class="form-control discount-percentage" value="0"
                                                    min="0" max="100" step="0.01">
                                                <div class="input-group-append">
                                                    <select name="items[0][discount_type]"
                                                        class="form-control discount-type">
                                                        <option value="amount">ريال</option>
                                                        <option value="percentage">%</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </td>
                                                                      <td data-label="الضريبة 1">
    <div class="input-group">
        <select name="items[0][tax_1]" class="form-control tax-select" data-target="tax_1"
            style="width: 150px;" onchange="updateHiddenInput(this)">
            <option value=""></option>
            <?php $__currentLoopData = $taxs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tax): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($tax->tax); ?>" data-id="<?php echo e($tax->id); ?>" data-name="<?php echo e($tax->name); ?>"
                    data-type="<?php echo e($tax->type); ?>">
                    <?php echo e($tax->name); ?>

                </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <input type="hidden" name="items[0][tax_1_id]">
    </div>
</td>



                                       <td data-label="الضريبة 2">
    <div class="input-group">
        <select name="items[0][tax_2]" class="form-control tax-select" data-target="tax_2"
            style="width: 150px;" onchange="updateHiddenInput(this)">
            <option value=""></option>
            <?php $__currentLoopData = $taxs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tax): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($tax->tax); ?>" data-id="<?php echo e($tax->id); ?>" data-name="<?php echo e($tax->name); ?>"
                    data-type="<?php echo e($tax->type); ?>">
                    <?php echo e($tax->name); ?>

                </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <input type="hidden" name="items[0][tax_2_id]">
    </div>
</td>
                                        
                                        
                                        <td>
                                            <span class="row-total">0.00</span>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-danger btn-sm remove-row">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot id="tax-rows">
                                    <tr>
                                        <td colspan="9" class="text-right">
                                            <button type="button" id="add-row" class="btn btn-success">
                                                <i class="fa fa-plus"></i> إضافة
                                            </button>
                                        </td>
                                    </tr>
                                      <?php
                                    $currencySymbol = '<img src="' . asset('assets/images/Saudi_Riyal.svg') . '" alt="ريال سعودي" width="13" style="display: inline-block; margin-left: 5px; vertical-align: middle;">';
                                    ?>
                                    <tr>
                                        <td colspan="7" class="text-right">المجموع الفرعي</td>
                                        <td><span id="subtotal">0.00</span></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td colspan="7" class="text-right">مجموع الخصومات</td>
                                        <td><span id="total-discount">0.00</span></td>
                                        <td></td>
                                    </tr>
                                <tr>
                                        <small id="tax-details"></small> <!-- مكان عرض تفاصيل الضرائب -->
                                    </tr>
                                    <tr>
                                        <td colspan="7" class="text-right">المجموع الكلي</td>
                                        <td><span id="grand-total">0.00</span></td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    </div>
    </div>

    <!------------------------->

    <div style="visibility: hidden;">
        <div class="whole_extra_item_add" id="whole_extra_item_add">
            <div class="delete_whole_extra_item_add" id="delete_whole_extra_item_add">

                <div class="col-12">
                    <div class="form-group row">
                        <div class="col-md-3">
                            <input class="form-control" type="text" name="" id=""
                                placeholder="عنوان اضافي">
                        </div>
                        <div class="col-md-6">
                            <input class="form-control" type="text" name="" id=""
                                placeholder="بيانات اضافيه">
                        </div>
                        <div class="form-label-group">
                            <span
                                class="btn btn-icon btn-icon rounded-circle btn-outline-success mr-1 mb-1 waves-effect waves-light addeventmore"><i
                                    class="fa fa-plus-circle"></i></span>
                            <span
                                class="btn btn-icon btn-icon rounded-circle btn-outline-danger mr-1 mb-1 waves-effect waves-light removeeventmore"><i
                                    class="fa fa-minus-circle"></i></span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    </div>
<?php $__env->startSection('scripts'); ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="<?php echo e(asset('assets/js/invoice.js')); ?>"></script>
     <script>
   function updateHiddenInput(selectElement) {
    // البحث عن أقرب صف يحتوي على العنصر المحدد
    var row = selectElement.closest('.item-row');

    // استخراج نوع الضريبة (tax_1 أو tax_2) من data-target
    var taxType = selectElement.getAttribute('data-target');

    // البحث عن الحقل المخفي داخل نفس الصف المرتبط بهذه الضريبة
    var hiddenInput = row.querySelector('input[name^="items"][name$="[' + taxType + '_id]"]');

    // تحديث قيمة الحقل المخفي بناءً على الضريبة المختارة
    if (hiddenInput) {
        hiddenInput.value = selectElement.options[selectElement.selectedIndex].getAttribute('data-id');
    }
}

 </script>
    <script>



document.addEventListener('change', function (e) {
    if (e.target && e.target.classList.contains('tax-select')) {
        let row = e.target.closest('tr');

        // الحصول على الضريبة 1
        let tax1Select = row.querySelector('[name^="items"][name$="[tax_1]"]');
        let tax1Name = tax1Select.options[tax1Select.selectedIndex].dataset.name;
        let tax1Value = parseFloat(tax1Select.value);
        
        // الحصول على الضريبة 2
        let tax2Select = row.querySelector('[name^="items"][name$="[tax_2]"]');
        let tax2Name = tax2Select.options[tax2Select.selectedIndex].dataset.name;
        let tax2Value = parseFloat(tax2Select.value);

        // إعداد النص لعرض الضرائب مع قيمتها
        let taxDetails = [];

        if (tax1Value > 0) {
            taxDetails.push(`${tax1Name} ${tax1Value}%`);
        }

        if (tax2Value > 0) {
            taxDetails.push(`${tax2Name} ${tax2Value}%`);
        }

        // إذا لم يتم اختيار أي ضريبة، عرض "الضريبة: 0"
        if (taxDetails.length === 0) {
            document.getElementById('tax-names-label').innerText = "الضريبة: 0";
        } else {
            document.getElementById('tax-names-label').innerText = taxDetails.join(" ، ");
        }

        // حساب إجمالي الضرائب بناءً على المجموع الفرعي
        let subtotal = 0;
        document.querySelectorAll(".item-row").forEach(function (row) {
            let quantity = parseFloat(row.querySelector(".quantity").value) || 0;
            let unitPrice = parseFloat(row.querySelector(".price").value) || 0;
            let itemTotal = quantity * unitPrice;
            subtotal += itemTotal;
        });

        let totalTax = 0;

        // حساب الضريبة 1
        if (tax1Value > 0) {
            totalTax += (subtotal * tax1Value) / 100;
        }

        // حساب الضريبة 2
        if (tax2Value > 0) {
            totalTax += (subtotal * tax2Value) / 100;
        }

        // عرض إجمالي الضرائب
        document.getElementById('total-tax').innerText = totalTax.toFixed(2);
    }
});



document.addEventListener("DOMContentLoaded", function () {
    function calculateTotals() {
        let subtotal = 0; // المجموع الفرعي (بدون ضريبة)
        let grandTotal = 0; // المجموع الكلي
        let taxDetails = {}; // تفاصيل الضرائب المختارة

        // مسح صفوف الضرائب السابقة
        document.querySelectorAll(".dynamic-tax-row").forEach(row => row.remove());

        document.querySelectorAll(".item-row").forEach(function (row) {
            let quantity = parseFloat(row.querySelector(".quantity").value) || 0;
            let unitPrice = parseFloat(row.querySelector(".price").value) || 0;
            let itemTotal = quantity * unitPrice; // هذا هو المجموع الكلي للعنصر
            subtotal += itemTotal; // إضافة إلى المجموع الفرعي

            // حساب الضرائب
            let tax1Value = parseFloat(row.querySelector("[name^='items'][name$='[tax_1]']").value) || 0;
            let tax1Type = row.querySelector("[name^='items'][name$='[tax_1]']").options[row.querySelector("[name^='items'][name$='[tax_1]']").selectedIndex].dataset.type;
            let tax1Name = row.querySelector("[name^='items'][name$='[tax_1]']").options[row.querySelector("[name^='items'][name$='[tax_1]']").selectedIndex].dataset.name;

            let tax2Value = parseFloat(row.querySelector("[name^='items'][name$='[tax_2]']").value) || 0;
            let tax2Type = row.querySelector("[name^='items'][name$='[tax_2]']").options[row.querySelector("[name^='items'][name$='[tax_2]']").selectedIndex].dataset.type;
            let tax2Name = row.querySelector("[name^='items'][name$='[tax_2]']").options[row.querySelector("[name^='items'][name$='[tax_2]']").selectedIndex].dataset.name;

            // حساب الضريبة 1
            if (tax1Value > 0) {
                let itemTax = 0;
                if (tax1Type === 'included') {
                    // الضريبة متضمنة: نستخرجها من المجموع الكلي
                    itemTax = itemTotal - (itemTotal / (1 + (tax1Value / 100)));
                } else {
                    // الضريبة غير متضمنة: نضيفها إلى المجموع الفرعي
                    itemTax = (itemTotal * tax1Value) / 100;
                }

                if (!taxDetails[tax1Name]) {
                    taxDetails[tax1Name] = 0;
                }
                taxDetails[tax1Name] += itemTax;
            }

            // حساب الضريبة 2
            if (tax2Value > 0) {
                let itemTax = 0;
                if (tax2Type === 'included') {
                    // الضريبة متضمنة: نستخرجها من المجموع الكلي
                    itemTax = itemTotal - (itemTotal / (1 + (tax2Value / 100)));
                } else {
                    // الضريبة غير متضمنة: نضيفها إلى المجموع الفرعي
                    itemTax = (itemTotal * tax2Value) / 100;
                }

                if (!taxDetails[tax2Name]) {
                    taxDetails[tax2Name] = 0;
                }
                taxDetails[tax2Name] += itemTax;
            }
        });

        // إضافة صفوف الضرائب ديناميكيًا
        let taxRowsContainer = document.getElementById("tax-rows");
        for (let taxName in taxDetails) {
            let taxRow = document.createElement("tr");
            taxRow.classList.add("dynamic-tax-row");

            taxRow.innerHTML = `
                <td colspan="7" class="text-right">
                    <span>${taxName}</span>
                </td>
                <td>
                    <span>${taxDetails[taxName].toFixed(2)}</span><?php echo $currencySymbol; ?>

                </td>
            `;

            taxRowsContainer.insertBefore(taxRow, document.querySelector("#tax-rows tr:last-child"));
        }

        // تحديث القيم في الواجهة
        document.getElementById("subtotal").innerText = subtotal.toFixed(2);
        document.getElementById("grand-total").innerText = (subtotal + Object.values(taxDetails).reduce((a, b) => a + b, 0)).toFixed(2);

        // إرسال الضرائب إلى الكنترولر
        let taxes = [];
        for (let taxName in taxDetails) {
            taxes.push({
                name: taxName,
                value: taxDetails[taxName],
            });
        }

        // إضافة الضرائب إلى بيانات الفاتورة
     document.querySelector("form").addEventListener("submit", function (e) {
    e.preventDefault();

    let formData = new FormData(this);

    // إضافة الضرائب إلى FormData
    let taxes = [];
    for (let taxName in taxDetails) {
        taxes.push({
            name: taxName,
            value: taxDetails[taxName],
        });
    }
    formData.append("taxes", JSON.stringify(taxes));

    // إرسال البيانات إلى الكنترولر
    fetch(this.action, {
        method: this.method,
        body: formData,
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
        },
    })
    .then(response => response.json())
    .then(data => {
        console.log("تم حفظ البيانات بنجاح:", data);
    })
    .catch(error => {
        console.error("حدث خطأ أثناء حفظ البيانات:", error);
    });
});

    }

    // حساب القيم عند تغيير المدخلات
    document.addEventListener("input", function (event) {
        if (event.target.matches(".quantity, .price, .tax-select")) {
            calculateTotals();
        }
    });

    // حساب القيم عند تحميل الصفحة
    calculateTotals();
});


    </script>
<?php $__env->stopSection(); ?>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/sehohoqm/hitstest.sehoool.com/resources/views/Purchases/view_purchase_price/create.blade.php ENDPATH**/ ?>