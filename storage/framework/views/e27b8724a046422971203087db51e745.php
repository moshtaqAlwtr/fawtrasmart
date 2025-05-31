<?php $__env->startSection('title'); ?>
     احصائيات هدف العملاء
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
  <style>
.hover-effect:hover {
    background-color: #f8f9fa;
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    transition: all 0.2s ease;
}

.progress {
    background-color: #e9ecef;
    border-radius: 10px;
}

.progress-bar {
    border-radius: 10px;
}

.badge {
    font-size: 0.85em;
    padding: 0.5em 0.75em;
}

.table-responsive {
    border-radius: 8px;
    overflow: hidden;
}

#nameFilter:focus, #groupFilter:focus, #sortFilter:focus {
    border-color: #86b7fe;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
}


</style>

<style>
    /* تنسيق DataTables */
    #clientsTable_filter input {
        border-radius: 5px;
        padding: 5px 10px;
        border: 1px solid #ddd;
    }
    
    /* تنسيق البادجات */
    .badge.bg-success { background-color: #28a745!important; }
    .badge.bg-warning { background-color: #ffc107!important; color: #212529!important; }
    .badge.bg-danger { background-color: #dc3545!important; }
    
    /* تأثيرات الصفوف */
    #clientsTable tbody tr:hover {
        background-color: #f8f9fa;
        transition: background-color 0.2s;
    }
    
    /* شريط التقدم */
    .progress-bar {
        transition: width 0.6s ease;
    }
    
    /* تكييف DataTables مع التصميم العربي */
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        margin: 0 3px;
        padding: 5px 10px;
        border-radius: 4px;
    }
</style>

<style>
    .form-label {
        font-weight: 500;
        margin-bottom: 0.5rem;
        color: #495057;
    }
    
    .form-control, .form-select {
        border-radius: 4px;
        padding: 8px 12px;
        border: 1px solid #ced4da;
        transition: border-color 0.15s ease-in-out;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #86b7fe;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
    }
    
    .btn {
        padding: 8px 16px;
        border-radius: 4px;
        font-weight: 500;
    }
    
    .card {
        border: 1px solid rgba(0, 0, 0, 0.125);
        border-radius: 6px;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }
</style>
<div class="card-body">
    <!-- الجزء العلوي: البحث السريع والتصفية -->
    <div class="card p-3 mb-4">
        <div class="row g-3 align-items-end">
            <!-- حقل البحث -->
            <div class="col-md-4 col-12">
                <label for="nameFilter" class="form-label">البحث السريع</label>
                <input type="text" id="nameFilter" class="form-control" placeholder="ابحث بالاسم، الكود، الموظف...">
            </div>

            <!-- فلترة الفئة -->
           <div class="col-md-3 col-12">
    <label for="groupFilter" class="form-label">تصفية حسب الفئة</label>
    <select id="groupFilter" class="form-control">
        <option value="">جميع الفئات</option>
        <option value="G">الفئة A++ (أكبر من 100%)</option>
        <option value="K">الفئة A (60% - 100%)</option>
        <option value="B">الفئة B (30% - 60%)</option>
        <option value="C">الفئة C (10% - 30%)</option>
        <option value="D">الفئة D (أقل من 10%)</option>
    </select>
</div>
            <!-- ترتيب النتائج -->
            <div class="col-md-3 col-12">
                <label for="sortFilter" class="form-label">ترتيب النتائج</label>
                <select id="sortFilter" class="form-control">
                    <option value="high">الأعلى تحصيلاً</option>
                    <option value="low">الأقل تحصيلاً</option>
                </select>
            </div>

            <!-- زر الإعادة -->
            <div class="col-md-2 col-12 d-grid">
                <button id="resetFilters" class="btn btn-outline-secondary">
                    <i class="fas fa-undo me-1"></i> إعادة تعيين
                </button>
            </div>
        </div>
    </div>

    <!-- الجزء السفلي: تصفية حسب التاريخ -->
    <div class="card p-3 mb-4">
        <form method="GET" action="<?php echo e(route('target.client')); ?>" id="dateFilterForm">
            <div class="row g-3">
                <div class="col-md-4 col-12">
                    <label for="date_from" class="form-label">من تاريخ</label>
                    <input type="date" name="date_from" id="date_from" class="form-control" value="<?php echo e(request('date_from')); ?>">
                </div>
                <div class="col-md-4 col-12">
                    <label for="date_to" class="form-label">إلى تاريخ</label>
                    <input type="date" name="date_to" id="date_to" class="form-control" value="<?php echo e(request('date_to')); ?>">
                </div>
                <div class="col-md-2 col-12 d-flex align-items-end">
                    <button class="btn btn-primary w-100" type="submit">
                        <i class="fas fa-filter me-1"></i> تطبيق
                    </button>
                </div>
                <div class="col-md-2 col-12 d-flex align-items-end">
                    <button class="btn btn-outline-danger w-100" type="button" id="resetDateFilter">
                        <i class="fas fa-times me-1"></i> إلغاء
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- JavaScript للتحكم في الوظائف -->


        <!-- جدول العملاء -->
        <?php if(isset($clients) && $clients->count() > 0): ?>
            <div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table id="clientsTable" class="table table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th>معلومات العميل</th>
                        <th>الفرع</th>
                        <th>الحي</th>
                        <th>المجموعة</th>
                        <th>التصنيف</th>
                        <th>نسبة تحقيق الهدف</th>
                    </tr>
                </thead>
                <tbody>
                   <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<tr data-url="<?php echo e(route('clients.show', $client->id)); ?>">
    <td>
        <h6 class="mb-0"><?php echo e($client->trade_name ?? ""); ?></h6>
        <small class="text-muted"><?php echo e($client->code ?? ""); ?></small>
        <p class="text-muted mb-0">
            <i class="fas fa-user me-1"></i>
            <?php echo e($client->first_name ?? ""); ?> <?php echo e($client->last_name ?? ""); ?>

        </p>
         <?php if($client->employees && $client->employees->count() > 0): ?>
        <?php $__currentLoopData = $client->employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <p class="text-muted mb-0">
                <i class="fas fa-user-tie me-1"></i>
                 <?php echo e($employee->full_name); ?>

            </p>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                    <span class="text-muted"><?php echo e(__('لا يوجد موظفون مرتبطون بهذا العميل')); ?></span>
                                <?php endif; ?>
    </td>
    <td><?php echo e($client->branch->name ?? ''); ?></td>
     <td><?php echo e($client->Neighborhoodname->name ?? ''); ?></td>
     <td><?php echo e($client->Neighborhoodname->Region->name ?? ''); ?></td>
 <td data-search="<?php echo e($client->group); ?>">
    <span class="badge bg-<?php echo e($client->group_class); ?>">
        <?php switch($client->group):
            case ('G'): ?>
                الفئة A++
                <?php break; ?>
            <?php case ('K'): ?>
                الفئة A
                <?php break; ?>
            <?php default: ?>
                الفئة <?php echo e($client->group); ?>

        <?php endswitch; ?>
    </span>
</td>

   

    <td data-order="<?php echo e($client->percentage); ?>">
        <div class="d-flex align-items-center mb-1">
            <span class="me-2"><?php echo e($client->percentage); ?>%</span>
            <div class="progress w-100" style="height: 8px;">
                <div class="progress-bar <?php echo e($client->percentage >= 100 ? 'bg-success' : 'bg-primary'); ?>" 
                     style="width: <?php echo e($client->percentage); ?>%;"></div>
            </div>
        </div>
        <small class="text-muted d-block">
            🔹 المدفوعات: <?php echo e(number_format($client->payments)); ?> ريال<br>
            🔹 السندات: <?php echo e(number_format($client->receipts)); ?> ريال<br>
            🔸 الإجمالي: <?php echo e(number_format($client->collected)); ?> / <?php echo e(number_format($target)); ?> ريال
        </small>
    </td>
</tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
        <?php else: ?>
            <div class="alert alert-danger text-xl-center" role="alert">
                <p class="mb-0">
                    لا توجد عملاء !!
                </p>
            </div>


        <?php endif; ?>
        
      
  <!-- زر الانتقال إلى آخر صفحة -->
                 
        

    </div>



<?php $__env->stopSection(); ?>



<?php $__env->startSection('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // 1. تعطيل أي إعادة ترتيب تلقائية
    if ($.fn.DataTable) {
        $('#clients-table').DataTable({
            ordering: false,  // تعطيل الترتيب التلقائي
            paging: false,
            info: false,
            searching: false
        });
    }

    // 2. تأكيد الترتيب يدوياً
    const rows = Array.from(document.querySelectorAll('#clients-table tbody tr'));
    rows.sort((a, b) => {
        const aVal = parseFloat(a.querySelector('td:nth-child(3)').textContent);
        const bVal = parseFloat(b.querySelector('td:nth-child(3)').textContent);
        return bVal - aVal;
    });

    const tbody = document.querySelector('#clients-table tbody');
    tbody.innerHTML = '';
    rows.forEach(row => tbody.appendChild(row));
});
</script>
<script>
    
        function handleRowClick(event, url) {
            let target = event.target;

            // السماح بالنقر على العناصر التالية بدون تحويل
            if (target.tagName.toLowerCase() === 'a' ||
                target.closest('.dropdown-menu') ||
                target.closest('.btn') ||
                target.closest('.form-check-input')) {
                return;
            }

            // تحويل المستخدم لصفحة العميل عند الضغط على الصف
            window.location = url;
        }
</script>



<?php $__env->startSection('scripts'); ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

<script>
$(document).ready(function() {
    // تهيئة DataTable مع إعدادات مخصصة
    var table = $('#clientsTable').DataTable({
        dom: '<"top"f>rt<"bottom"lip><"clear">',
        language: {
            url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/ar.json'
        },
        columnDefs: [
            { 
                type: 'num', 
                targets: 3, // العمود الرابع (نسبة التحصيل)
                render: function(data, type) {
                    if (type === 'sort') {
                        return parseFloat(data.split('%')[0]) || 0;
                    }
                    return data;
                }
            },
            { orderable: false, targets: [0, 1, 2] } // تعطيل الترتيب لهذه الأعمدة
        ],
        initComplete: function() {
            $('.dataTables_filter').hide();
        }
    });

    // فلترة مخصصة تعمل مع DataTables
    function applyCustomFilters() {
        var groupValue = $('#groupFilter').val();
        var sortValue = $('#sortFilter').val();
        
        // فلترة حسب الفئة
        if (groupValue) {
            table.column(4).search(groupValue, true, false).draw();
        } else {
            table.column(4).search('').draw();
        }
        
        // ترتيب حسب النسبة
        if (sortValue === 'high') {
            table.order([5, 'desc']).draw();
        } else {
            table.order([5, 'asc']).draw();
        }
    }
    
    // بحث بالاسم (يشمل جميع الأعمدة)
    $('#nameFilter').on('keyup', function() {
        table.search(this.value).draw();
    });
    
    // أحداث الفلترة المخصصة
    $('#groupFilter, #sortFilter').on('change', applyCustomFilters);
    
    // إعادة تعيين الفلاتر
    $('#resetFilters').click(function() {
        $('#nameFilter').val('');
        $('#groupFilter').val('');
        $('#sortFilter').val('high');
        table.search('').columns().search('').order([3, 'desc']).draw();
    });
    
    // التفعيل الأولي
    applyCustomFilters();
    
    // حل مشكلة النقر على الصفوف مع وجود DataTables
    $('#clientsTable tbody').on('click', 'tr', function(e) {
        if ($(e.target).is('a, button, input, select, textarea, .no-click')) {
            return;
        }
        var data = table.row(this).data();
        if (data && data._url) {
            window.location.href = data._url;
        }
    });
});



</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // إعادة تعيين كل الفلاتر
    document.getElementById('resetFilters').addEventListener('click', function() {
        // إعادة تعيين الفلاتر العلوية
        document.getElementById('nameFilter').value = '';
        document.getElementById('groupFilter').value = '';
        document.getElementById('sortFilter').value = 'high';
        
        // إعادة تعيين فلاتر التاريخ
        document.getElementById('date_from').value = '';
        document.getElementById('date_to').value = '';
        
        // إرسال الفورم لتطبيق التغييرات
        document.getElementById('dateFilterForm').submit();
    });

    // إعادة تعيين فلاتر التاريخ فقط
    document.getElementById('resetDateFilter').addEventListener('click', function() {
        document.getElementById('date_from').value = '';
        document.getElementById('date_to').value = '';
        document.getElementById('dateFilterForm').submit();
    });
});
</script>


<?php $__env->stopSection(); ?>
<?php $__env->stopSection(); ?>









































































<?php echo $__env->make('master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\fawtramsmart\fawtra\resources\views/employee_targets/client.blade.php ENDPATH**/ ?>