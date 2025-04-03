@extends('master')

@section('title')
    اضافة عملية الدفع
@stop

@section('content')
@push('styles')
<style>
    .tags-container {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-top: 10px;
    }
    .tag {
        background-color: #e9ecef;
        padding: 5px 10px;
        border-radius: 20px;
        display: flex;
        align-items: center;
    }
    .tag-remove {
        margin-right: 5px;
        cursor: pointer;
    }
    .select2-container--default .select2-selection--multiple {
        min-height: 38px;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
    background-color: #e9ecef;
    border: none;
    border-radius: 20px;
    padding: 0 10px;
}

.select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
    color: #999;
    margin-right: 5px;
}
#installment-display {
    cursor: pointer;
    background-color: #f8f9fa;
}

.list-group-item {
    transition: all 0.3s;
}

.list-group-item:hover {
    background-color: #f1f1f1;
}

.input-group-append button {
    border-color: #ced4da;
}
</style>
@endpush

<form action="{{ route('salary-advance.store-payments', $salaryAdvance->id) }}" method="POST">
    @csrf
    
    <!-- باقي عناصر الفورم -->
    
    <div class="card">
        <div class="card-body">
            <div class="row">
            <!-- حقل عرض القسط المختار -->
    <div class="col-md-4">
        <label class="form-label">القسط المختار</label>
        <div class="input-group">
            <input type="text" id="selected-installment-display" class="form-control" readonly>
            <input type="hidden" id="selected-installment-number" name="installment_number">
            <div class="input-group-append">
                <button type="button" class="btn btn-outline-secondary" onclick="clearSelection()">
                    <i class="fa fa-times"></i>
                </button>
            </div>
        </div>
    </div>

<!-- Modal لعرض الأقساط -->
<div class="modal fade" id="installmentsModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">الأقساط الغير مدفوعة</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="list-group">
                    @foreach($unpaidInstallments as $installment)
                    <a href="#" class="list-group-item list-group-item-action" 
                       onclick="selectInstallment(event, 
                                {{ $installment['amount'] }}, 
                                '{{ $installment['due_date'] }}',
                                {{ $installment['number'] }})">
                        <div class="d-flex justify-content-between">
                            <span class="font-weight-bold">القسط {{ $installment['number'] }}</span>
                            <span>{{ number_format($installment['amount'], 2) }} ر.س</span>
                            <span>{{ $installment['due_date'] }}</span>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
                
       <!-- حقل المبلغ -->
    <div class="col-md-4">
        <label for="amount" class="form-label">المبلغ <span style="color: red">*</span></label>
        <input type="number" id="amount" name="amount" class="form-control" required step="0.01" min="0.01">
    </div>
    
                <!-- حقل تاريخ الدفع -->
    <div class="col-md-4">
        <label for="payment_date" class="form-label">تاريخ الدفع <span style="color: red">*</span></label>
        <input type="date" id="payment_date" name="payment_date" class="form-control" required>
    </div>
    <!-- حفل حساب الدفع -->
    <div class="col-md-4">
        <label for="account_id" class="form-label">حساب الدفع <span style="color: red">*</span></label>
        <select name="account_id" id="account_id" class="form-control" required>
            @foreach($accounts as $account)
            <option value="{{ $account->id }}">{{ $account->name }}</option>
            @endforeach
        </select>
    </div>
            </div>
             <!-- Modal لعرض الأقساط الغير مدفوعة -->
    <div class="modal fade" id="installmentsModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">الأقساط الغير مدفوعة</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>المبلغ</th>
                                <th>تاريخ الاستحقاق</th>
                                <th>اختيار</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($unpaidInstallments as $installment)
                            <tr>
                                <td>{{ $installment['number'] }}</td>
                                <td>{{ number_format($installment['amount'], 2) }} ر.س</td>
                                <td>{{ $installment['due_date'] }}</td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-primary"
                                            onclick="selectInstallment(
                                                {{ $installment['number'] }},
                                                {{ $installment['amount'] }},
                                                '{{ $installment['due_date'] }}'
                                            )">
                                        اختيار
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <button type="submit" class="btn btn-primary">حفظ الدفعة</button>
            
            <!-- عرض الأقساط المختارة كـ tags -->
         
        </div>
    </div>
    
    
</form>

@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // تهيئة select2 متعدد
    $('.select2-multiple').select2({
        placeholder: "اختر الأقساط",
        allowClear: true
    });
    
    // عند اختيار أقساط
    $('#installments-select').on('change', function() {
        const selectedOptions = $(this).select2('data');
        const container = $('#selected-installments');
        const hiddenFields = $('#hidden-fields');
        
        container.empty();
        hiddenFields.empty();
        
        selectedOptions.forEach((option, index) => {
            // إضافة tag
            container.append(`
                <div class="tag">
                    <span class="tag-remove" data-id="${option.id}">×</span>
                    ${option.text}
                </div>
            `);
            
            // إضافة حقول مخفية
            hiddenFields.append(`
                <input type="hidden" name="payments[${index}][installment_number]" value="${option.id}">
                <input type="hidden" name="payments[${index}][amount]" value="${$(option.element).data('amount')}">
                <input type="hidden" name="payments[${index}][payment_date]" value="${$(option.element).data('date')}">
            `);
        });
    });
    
    // إزالة tag
    $(document).on('click', '.tag-remove', function() {
        const id = $(this).data('id');
        const option = $('#installments-select option[value="'+id+'"]');
        option.prop('selected', false);
        $('#installments-select').trigger('change');
    });
});
</script>
<script>
function showInstallmentsModal() {
    $('#installmentsModal').modal('show');
}

function selectInstallment(event, amount, dueDate, number) {
    event.preventDefault();
    
    // تعبئة الحقول
    $('#installment-display').val(`القسط ${number} - ${amount} ر.س - ${dueDate}`);
    $('#selected-amount').val(amount);
    $('#selected-due-date').val(dueDate);
    
    // إغلاق المودال
    $('#installmentsModal').modal('hide');
}

function clearInstallment() {
    $('#installment-display').val('');
    $('#selected-amount').val('');
    $('#selected-due-date').val('');
}
</script>
<script>
function showInstallmentsModal() {
    $('#installmentsModal').modal('show');
}

function selectInstallment(number, amount, dueDate) {
    // تعبئة الحقول
    $('#selected-installment-display').val(`القسط ${number} - ${amount} ر.س`);
    $('#selected-installment-number').val(number);
    $('#amount').val(amount);
    $('#payment_date').val(dueDate);
    
    // إغلاق المودال
    $('#installmentsModal').modal('hide');
}

function clearSelection() {
    $('#selected-installment-display').val('');
    $('#selected-installment-number').val('');
    $('#amount').val('');
    $('#payment_date').val('');
}

// فتح المودال عند النقر على حقل القسط
$('#selected-installment-display').click(function() {
    showInstallmentsModal();
});
</script>
@endsection