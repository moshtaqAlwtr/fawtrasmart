

@extends('master')

@section('title')
     احصائيات هدف العملاء
@stop

@section('content')
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
    <div class="card p-3 mb-4">
        <div class="row g-3 align-items-end">
            <!-- حقل البحث -->
            <div class="col-md-4 col-12">
                <label for="nameFilter" class="form-label">البحث</label>
                <input type="text" id="nameFilter" class="form-control" placeholder="اسم، كود، أو فرع...">
            </div>

            <!-- فلترة الفئة -->
            <div class="col-md-3 col-12">
                <label for="groupFilter" class="form-label">الفئة</label>
                <select id="groupFilter" class="form-control">
                    <option value="">جميع الفئات</option>
                    <option value="A">الفئة A</option>
                    <option value="B">الفئة B</option>
                    <option value="C">الفئة C</option>
                </select>
            </div>

            <!-- ترتيب النتائج -->
            <div class="col-md-3 col-12">
                <label for="sortFilter" class="form-label">الترتيب حسب</label>
                <select id="sortFilter" class="form-control">
                    <option value="high">الأعلى تحصيلاً</option>
                    <option value="low">الأقل تحصيلاً</option>
                </select>
            </div>

            <!-- زر الإعادة -->
            <div class="col-md-2 col-12 d-grid">
                <button id="resetFilters" class="btn btn-outline-secondary mt-auto">
                    <i class="fas fa-undo me-1"></i> إعادة تعيين
                </button>
            </div>
        </div>
    </div>

   
</div>
        <!-- جدول العملاء -->
        @if (isset($clients) && $clients->count() > 0)
            <div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table id="clientsTable" class="table table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th>معلومات العميل</th>
                        <th>الفرع</th>
                        <th>التصنيف</th>
                        <th>نسبة تحقيق الهدف</th>
                    </tr>
                </thead>
                <tbody>
                   @foreach ($clients as $client)
<tr data-url="{{ route('clients.show', $client->id) }}">
    <td>
        <h6 class="mb-0">{{ $client->trade_name ?? ""}}</h6>
        <small class="text-muted">{{ $client->code ?? ""}}</small>
        <p class="text-muted mb-0">
            <i class="fas fa-user me-1"></i>
            {{ $client->first_name ?? "" }} {{ $client->last_name ?? "" }}
        </p>
        @if ($client->employee)
            <p class="text-muted mb-0">
                <i class="fas fa-user-tie me-1"></i>
                {{ $client->employee->first_name ?? "" }} {{ $client->employee->last_name ?? "" }}
            </p>
        @endif
    </td>
    <td>{{ $client->branch->name ?? '' }}</td>
    <td data-search="{{ $client->group }}">
        <span class="badge bg-{{ $client->group_class }}">
            الفئة {{ $client->group }}
        </span>
    </td>
    <td data-order="{{ $client->percentage }}">
        <div class="d-flex align-items-center mb-1">
            <span class="me-2">{{ $client->percentage }}%</span>
            <div class="progress w-100" style="height: 8px;">
                <div class="progress-bar {{ $client->percentage >= 100 ? 'bg-success' : 'bg-primary' }}" 
                     style="width: {{ $client->percentage }}%;"></div>
            </div>
        </div>
        <small class="text-muted d-block">
            🔹 المدفوعات: {{ number_format($client->payments) }} ريال<br>
            🔹 السندات: {{ number_format($client->receipts) }} ريال<br>
            🔸 الإجمالي: {{ number_format($client->collected) }} / {{ number_format($target) }} ريال
        </small>
    </td>
</tr>
@endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
        @else
            <div class="alert alert-danger text-xl-center" role="alert">
                <p class="mb-0">
                    لا توجد عملاء !!
                </p>
            </div>


        @endif
        
      
  <!-- زر الانتقال إلى آخر صفحة -->
                 
        

    </div>



@endsection



@section('scripts')
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



@section('scripts')
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
            table.column(2).search(groupValue, true, false).draw();
        } else {
            table.column(2).search('').draw();
        }
        
        // ترتيب حسب النسبة
        if (sortValue === 'high') {
            table.order([3, 'desc']).draw();
        } else {
            table.order([3, 'asc']).draw();
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
@endsection
@endsection








































































