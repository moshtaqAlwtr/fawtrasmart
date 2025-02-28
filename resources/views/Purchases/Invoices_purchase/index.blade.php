@extends('master')

@section('title')
    ادارة فواتير الشراء
@stop

@section('content')

    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">ادارة فواتير الشراء</h2>
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

    @include('layouts.alerts.error')
    @include('layouts.alerts.success')

    <div class="content-body">
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center gap-2">

                    </div>

                    <div class="d-flex align-items-center gap-2">
                        <nav aria-label="Page navigation">
                            <ul class="pagination pagination-sm mb-0">
                                <li class="page-item">
                                    <button class="btn btn-sm btn-outline-secondary px-2" aria-label="Previous">
                                        <i class="fa fa-angle-right"></i>
                                    </button>
                                </li>
                                <li class="page-item mx-2">
                                    <span class="text-muted">صفحة 1 من 1</span>
                                </li>
                                <li class="page-item">
                                    <button class="btn btn-sm btn-outline-secondary px-2" aria-label="Next">
                                        <i class="fa fa-angle-left"></i>
                                    </button>
                                </li>
                            </ul>
                        </nav>

                        <span class="text-muted mx-2">1-1 من 1</span>

                        <a href="{{ route('invoicePurchases.create') }}" class="btn btn-success">
                            <i class="fa fa-plus me-1"></i>
                            اضف فاتورة شراء
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center p-2">
                <div class="d-flex gap-2">
                    <span class="hide-button-text">بحث وتصفية</span>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <button class="btn btn-outline-secondary btn-sm" onclick="toggleSearchFields(this)">
                        <i class="fa fa-times"></i>
                        <span class="hide-button-text">اخفاء</span>
                    </button>
                    <button class="btn btn-outline-secondary btn-sm" data-bs-toggle="collapse"
                        data-bs-target="#advancedSearchForm" onclick="toggleSearchText(this)">
                        <i class="fa fa-filter"></i>
                        <span class="button-text">متقدم</span>
                    </button>
                </div>
            </div>

            <div class="card-body">
                <form class="form" id="searchForm" method="GET" action="{{ route('invoicePurchases.index') }}">
                    <div class="row g-3">
                        <!-- الحقول الأساسية -->
                        <div class="col-md-4">
                            <select name="employee_search" class="form-control">
                                <option value="">البحث بواسطة إسم المورد أو الرقم التعريفي</option>
                                @foreach ($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}" {{ request('employee_search') == $supplier->id ? 'selected' : '' }}>
                                        {{ $supplier->trade_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <input type="text" name="number_invoice" class="form-control"
                                   placeholder="رقم الفاتورة" value="{{ request('number_invoice') }}">
                        </div>

                        <div class="col-md-4">
                            <select name="status" class="form-control">
                                <option value="">الحالة</option>
                                <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>نشط</option>
                                <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>غير نشط</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <select name="payment_status" class="form-control">
                                <option value="">اختر حالة الدفع</option>
                                <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>مدفوع</option>
                                <option value="partial" {{ request('payment_status') == 'partial' ? 'selected' : '' }}>مدفوع جزئيا</option>
                                <option value="unpaid" {{ request('payment_status') == 'unpaid' ? 'selected' : '' }}>غير مدفوع</option>
                                <option value="returned" {{ request('payment_status') == 'returned' ? 'selected' : '' }}>مرتجع</option>
                                <option value="overpaid" {{ request('payment_status') == 'overpaid' ? 'selected' : '' }}>مدفوعة بالزيادة</option>
                                <option value="draft" {{ request('payment_status') == 'draft' ? 'selected' : '' }}>مسودة</option>
                            </select>
                        </div>

                        <div class="col-md-4 advanced-field" style="display: none;">
                            <select name="created_by" class="form-control">
                                <option value="">اضيفت بواسطة</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" {{ request('created_by') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 advanced-field" style="display: none;">
                            <select name="tag" class="form-control">
                                <option value="">اختر الوسم</option>
                                @foreach ($tags ?? [] as $tag)
                                    <option value="{{ $tag->id }}" {{ request('tag') == $tag->id ? 'selected' : '' }}>
                                        {{ $tag->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- حقول البحث المتقدم -->
                    <div class="collapse" id="advancedSearchForm">
                        <div class="row g-3 mt-2">
                            <div class="col-md-4">
                                <input type="text" name="contract" class="form-control"
                                       placeholder="حقل مخصص" value="{{ request('contract') }}">
                            </div>

                            <div class="col-md-4">
                                <input type="text" name="description" class="form-control"
                                       placeholder="تحتوي على البند" value="{{ request('description') }}">
                            </div>

                            <div class="col-md-4">
                                <select name="source" class="form-control">
                                    <option value="">إختر المصدر</option>
                                    <option value="invoice" {{ request('source') == 'invoice' ? 'selected' : '' }}>فاتورة</option>
                                    <option value="return" {{ request('source') == 'return' ? 'selected' : '' }}>المرتجع</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <select name="delivery_status" class="form-control">
                                    <option value="">حالة التسليم</option>
                                    <option value="received" {{ request('delivery_status') == 'received' ? 'selected' : '' }}>مستلم</option>
                                    <option value="rejected" {{ request('delivery_status') == 'rejected' ? 'selected' : '' }}>مرفوض</option>
                                    <option value="pending" {{ request('delivery_status') == 'pending' ? 'selected' : '' }}>تحت التسليم</option>
                                    <option value="partial_rejected" {{ request('delivery_status') == 'partial_rejected' ? 'selected' : '' }}>مرفوض جزئيا</option>
                                    <option value="partial_received" {{ request('delivery_status') == 'partial_received' ? 'selected' : '' }}>مستلم جزئيا</option>
                                    <option value="not_received" {{ request('delivery_status') == 'not_received' ? 'selected' : '' }}>لم يستلم</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <input type="date" name="start_date_from" class="form-control"
                                       value="{{ request('start_date_from') }}" placeholder="التاريخ من">
                            </div>

                            <div class="col-md-4">
                                <input type="date" name="start_date_to" class="form-control"
                                       value="{{ request('start_date_to') }}" placeholder="التاريخ الى">
                            </div>

                            <div class="col-md-4">
                                <input type="date" name="created_at_from" class="form-control"
                                       value="{{ request('created_at_from') }}" placeholder="تاريخ الانشاء من">
                            </div>

                            <div class="col-md-4">
                                <input type="date" name="created_at_to" class="form-control"
                                       value="{{ request('created_at_to') }}" placeholder="تاريخ الانشاء الى">
                            </div>
                        </div>
                    </div>

                    <div class="form-actions mt-2">
                        <button type="submit" class="btn btn-primary">بحث</button>
                        <a href="{{ route('invoicePurchases.index') }}" class="btn btn-outline-warning">إلغاء</a>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                @if ($purchaseInvoices->count() > 0)
                    <table class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th style="width: 5%">
                                    <input type="checkbox" class="form-check-input" id="selectAll">
                                </th>
                                <th>رقم الفاتورة</th>
                                <th>المورد</th>
                                <th>التاريخ</th>
                                <th>طريقة الدفع</th>
                                <th>المبلغ الإجمالي</th>

                                <th>حالة الاستلام</th>
                                <th style="width: 10%">خيارات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($purchaseInvoices as $invoice)
                                <tr>
                                    <td>
                                        <input type="checkbox" class="form-check-input order-checkbox" value="{{ $invoice->id }}">
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar me-2" style="background-color: #4B6584">
                                                <span class="avatar-content">{{ Str::upper(substr($invoice->reference_number, 0, 1)) }}</span>
                                            </div>
                                            <div>
                                                {{ $invoice->reference_number }}
                                                <div class="text-muted small">#{{ $invoice->id }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $invoice->supplier->trade_name ?? 'غير محدد' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($invoice->date)->format('Y-m-d') }}</td>
                                    <td>
                                        @switch($invoice->payment_method)
                                            @case('1')
                                                <span class="badge bg-success">نقدي</span>
                                                @break
                                            @case('2')
                                                <span class="badge bg-warning">آجل</span>
                                                @break
                                            @default
                                                <span class="badge bg-secondary">غير محدد</span>
                                        @endswitch
                                    </td>
                                    <td>{{ number_format($invoice->grand_total, 2) }} ريال</td>

                                    <td>
                                        @switch($invoice->status)
                                            @case(1)
                                                <span class="badge bg-success">مدفوعة  </span>
                                                @break
                                            @case(2)
                                                <span class="badge bg-warning">مدفوع جزئيًا</span>
                                                @break
                                            @case(3)
                                                <span class="badge bg-danger">مستلم (غير مدفوع)</span>
                                                @break
                                            @case(4)
                                                <span class="badge bg-success">مدفوع ومستلم</span>
                                                @break
                                            @case(5)
                                                <span class="badge bg-info">مدفوع (غير مستلم)</span>
                                                @break
                                            @default
                                                <span class="badge bg-secondary">غير محدد</span>
                                        @endswitch
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <div class="dropdown">
                                                <button class="btn bg-gradient-info fa fa-ellipsis-v mr-1 mb-1 btn-sm"
                                                        type="button"
                                                        data-bs-toggle="dropdown"
                                                        aria-expanded="false">
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item" href="{{ route('invoicePurchases.show', $invoice->id) }}">
                                                        <i class="fa fa-eye me-2 text-primary"></i>عرض
                                                    </a>
                                                    <a class="dropdown-item" href="{{ route('invoicePurchases.edit', $invoice->id) }}">
                                                        <i class="fa fa-edit me-2 text-success"></i>تعديل
                                                    </a>
                                                    <a class="dropdown-item" href="" target="_blank">
                                                        <i class="fa fa-print me-2 text-info"></i>طباعة
                                                    </a>
                                                    <a class="dropdown-item text-danger delete-invoice" href="#" data-id="{{ $invoice->id }}">
                                                        <i class="fa fa-trash me-2"></i>حذف
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>


                @else
                    <div class="alert alert-info text-center" role="alert">
                        <p class="mb-0">لا يوجد فواتير مشتريات مضافة حتى الآن</p>
                    </div>
                @endif
            </div>
        </div>





    @endsection

    @section('css')
        <style>
            .col-md-1-5 {
                flex: 0 0 12.5%;
                max-width: 12.5%;
                padding-right: 15px;
                padding-left: 15px;
            }

            .form-control {
                margin-bottom: 10px;
            }
        </style>
    @endsection
    @section('scripts')
        <script>
            function toggleSearchText(button) {
                const buttonText = button.querySelector('.button-text');
                const advancedFields = document.querySelectorAll('.advanced-field');

                if (buttonText.textContent.trim() === 'متقدم') {
                    buttonText.textContent = 'بحث بسيط';
                    advancedFields.forEach(field => field.style.display = 'block');
                } else {
                    buttonText.textContent = 'متقدم';
                    advancedFields.forEach(field => field.style.display = 'none');
                }
            }

            function toggleSearchFields(button) {
                const searchForm = document.getElementById('searchForm');
                const buttonText = button.querySelector('.hide-button-text');
                const icon = button.querySelector('i');

                if (buttonText.textContent === 'اخفاء') {
                    searchForm.style.display = 'none';
                    buttonText.textContent = 'اظهار';
                    icon.classList.remove('fa-times');
                    icon.classList.add('fa-eye');
                } else {
                    searchForm.style.display = 'block';
                    buttonText.textContent = 'اخفاء';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-times');
                }
            }

        </script>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const deleteButtons = document.querySelectorAll('.delete-invoice');

                    deleteButtons.forEach(button => {
                        button.addEventListener('click', function(e) {
                            e.preventDefault();
                            const invoiceId = this.getAttribute('data-id');

                            Swal.fire({
                                title: 'تأكيد الحذف',
                                text: 'هل أنت متأكد من حذف هذه الفاتورة؟',
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'نعم، احذف',
                                cancelButtonText: 'إلغاء'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // إرسال طلب حذف باستخدام AJAX
                                    axios.delete(`/invoicePurchases/${invoiceId}`)
                                        .then(response => {
                                            Swal.fire(
                                                'تم الحذف!',
                                                'تم حذف الفاتورة بنجاح.',
                                                'success'
                                            ).then(() => {
                                                // إعادة تحميل الصفحة
                                                window.location.reload();
                                            });
                                        })
                                        .catch(error => {
                                            Swal.fire(
                                                'خطأ!',
                                                'حدث خطأ أثناء حذف الفاتورة.',
                                                'error'
                                            );
                                        });
                                }
                            });
                        });
                    });
                });
                </script>
    @endsection

