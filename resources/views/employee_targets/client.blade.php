

@extends('master')

@section('title')
     احصائيات هدف العملاء
@stop

@section('content')
  

        <!-- جدول العملاء -->
        @if (isset($clients) && $clients->count() > 0)
            <div class="card">
                
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="fawtra" class="table table-hover mb-0" data-order='[[2, "desc"]]'>
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
                                    <tr onclick="handleRowClick(event, '{{ route('clients.show', $client->id) }}')"
                                        style="cursor: pointer;" class="hover-effect">
                                       
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
<td>
    <span class="badge bg-{{ $client->group_class }}">
        المجموعة {{ $client->group }}
    </span>
   
</td>
                             <td>
                                 
                <div class="d-flex align-items-center mb-1">
                    <span class="me-2">{{ $client->percentage }}%</span>
                    <div class="progress w-100" style="height: 8px;">
                        <div class="progress-bar
                            {{ $client->percentage >= 100 ? 'bg-success' : ($client->percentage >= 80 ? 'bg-success' : 'bg-success') }}"
                            role="progressbar"
                            style="width: {{ $client->percentage }}%;"
                            aria-valuenow="{{ $client->percentage }}"
                            aria-valuemin="0" aria-valuemax="100">
                        </div>
                    </div>
                </div>
                <small class="text-muted d-block">
                    🔹 المدفوعات: {{ number_format($client->payments) }} ريال<br>
                    🔹 السندات: {{ number_format($client->receipts) }} ريال<br>
                    🔸 الإجمالي: {{ number_format($client->collected) }} / {{ number_format($target) }} ريال
                </small>
            </td>


                                    

                                        <!-- Modal Delete -->
                                       
                                    

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
@endsection

