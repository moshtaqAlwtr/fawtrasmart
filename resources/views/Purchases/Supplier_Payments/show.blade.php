@extends('master')

@section('title')
    عرض عملية الدفع
@stop

@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">عرض عملية الدفع </h2>
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

        <div class="card">
            <div class="card-body">
                <div class="card-header bg-white p-3">
                    <div class="d-flex justify-content-between align-items-center flex-row-reverse">
                        <!-- الأزرار -->
                        <div class="d-flex gap-3"> <!-- زيادة المسافة بين الأزرار -->
                            <a href="{{ route('PaymentSupplier.editSupplierPayment', $payment->id) }}" class="btn btn-purple">
                                <i class="fas fa-edit"></i>
                                تعديل
                            </a>
                            <div class="dropdown">
                                <button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-receipt"></i>
                                    إيصال استلام
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <i class="fas fa-file-alt me-2"></i>
                                            إيصال مدفوعات
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <i class="fas fa-print me-2"></i>
                                            إيصال حراري
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                <i class="fas fa-trash"></i>
                                حذف
                            </button>
                        </div>

                        <!-- النصوص -->
                        <div class="text-start"> <!-- لجعل النصوص في الجهة اليسرى -->
                            <div class="d-flex align-items-center gap-2">
                                <h5 class="mb-0">
                                    عملية الدفع #{{ str_pad($payment->id, 6, '0', STR_PAD_LEFT) }}
                                    @if ($payment->payment_status == 1)
                                        <span class="badge bg-success ms-2">تحت المراجعة</span>
                                    @elseif ($payment->payment_status == 2)
                                        <span class="badge bg-success ms-2">مكتمل</span>
                                    @elseif ($payment->payment_status == 3)
                                        <span class="badge bg-danger ms-2">مرفوض</span>
                                    @elseif ($payment->payment_status == 4)
                                        <span class="badge bg-warning ms-2">تحت التسليم</span>
                                    @endif
                                </h5>
                            </div>
                            <div class="text-muted mt-1">
                                <span>{{ $payment->purchase->supplier->trade_name }}</span>
                                <a href="#" class="text-primary ms-3">Journal #49531</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm">
            <!-- رأس البطاقة -->


            <!-- محتوى البطاقة -->
            <div class="card-body p-4">
                <div class="row g-4">
                    <!-- بيانات الدفع -->
                    <div class="col-md-6">
                        <div class="card h-100">
                            <div class="card-header bg-light py-3">
                                <h6 class="card-title mb-0">
                                    <i class="fas fa-money-bill-wave me-2 text-primary"></i>
                                    بيانات الدفع
                                </h6>
                            </div>
                            <div class="card-body">
                                <table class="table table-striped mb-0">
                                    <tr>
                                        <th width="35%">رقم فاتورة الشراء</th>
                                        <td>{{ $payment->purchase->invoice_number }}</td>
                                    </tr>
                                    <tr>
                                        <th>وسيلة الدفع</th>
                                        <td>
                                            @switch($payment->payment_method)
                                                @case(1)
                                                    <i class="fas fa-money-bill text-success me-1"></i> نقدي
                                                @break

                                                @case(2)
                                                    <i class="fas fa-university text-primary me-1"></i> تحويل بنكي
                                                @break

                                                @case(3)
                                                    <i class="fas fa-money-check text-info me-1"></i> شيك
                                                @break

                                                @default
                                                    <i class="fas fa-question-circle text-secondary me-1"></i> غير محدد
                                            @endswitch
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>رقم المرجع</th>
                                        <td>{{ $payment->reference_number ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>تاريخ الدفع</th>
                                        <td><i class="far fa-calendar-alt me-1"></i> {{ $payment->payment_date }}</td>
                                    </tr>
                                    <tr>
                                        <th>الموظف المسؤول</th>
                                        <td><i class="fas fa-user me-1"></i>
                                            {{ $payment->employee->full_name ?? 'غير محدد' }}</td>
                                    </tr>
                                    <tr>
                                        <th>الخزينة</th>
                                        <td><i class="fas fa-cash-register me-1"></i>
                                            {{ $payment->treasury->name ?? 'الرئيسية' }}</td>
                                    </tr>
                                    <tr>
                                        <th>ملاحظات</th>
                                        <td>{{ $payment->notes ?? '-' }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- بيانات المورد -->
                    <div class="col-md-6">
                        <div class="card h-100">
                            <div class="card-header bg-light py-3">
                                <h6 class="card-title mb-0">
                                    <i class="fas fa-user-tie me-2 text-primary"></i>
                                    بيانات المورد
                                </h6>
                            </div>
                            <div class="card-body">
                                <table class="table table-striped mb-0">
                                    <tr>
                                        <th width="35%">اسم المورد</th>
                                        <td>{{ $payment->purchase->supplier->trade_name }}</td>
                                    </tr>
                                    <tr>
                                        <th>رقم الهاتف</th>
                                        <td><i class="fas fa-phone me-1"></i>
                                            {{ $payment->purchase->supplier->phone ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>المدينة</th>
                                        <td><i class="fas fa-map-marker-alt me-1"></i>
                                            {{ $payment->purchase->supplier->city ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>المنطقة</th>
                                        <td><i class="fas fa-map me-1"></i>
                                            {{ $payment->purchase->supplier->region ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>الرمز البريدي</th>
                                        <td><i class="fas fa-mailbox me-1"></i>
                                            {{ $payment->purchase->supplier->postal_code ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>البلد</th>
                                        <td><i class="fas fa-globe me-1"></i>
                                            {{ $payment->purchase->supplier->country ?? 'SA' }}</td>
                                    </tr>
                                    <tr>
                                        <th>العملة</th>
                                        <td><i class="fas fa-money-bill-wave me-1"></i>
                                            {{ $payment->purchase->supplier->currency ?? 'SAR' }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Delete -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">تأكيد الحذف</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p class="mb-0">هل أنت متأكد من حذف عملية الدفع رقم
                        #{{ str_pad($payment->id, 6, '0', STR_PAD_LEFT) }}؟</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">إلغاء</button>
                    <form action="{{ route('paymentsClient.destroy', $payment->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">تأكيد الحذف</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        .card {
            border: 1px solid rgba(0, 0, 0, .125);
            border-radius: 0.5rem;
        }

        .card-header {
            border-bottom: 1px solid rgba(0, 0, 0, .125);
        }

        .btn-purple {
            color: #fff;
            background-color: #6f42c1;
            border-color: #6f42c1;
        }

        .btn-purple:hover {
            color: #fff;
            background-color: #5e35b1;
            border-color: #5e35b1;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
        }

        .table th {
            font-weight: 600;
            color: #495057;
            background-color: #f8f9fa;
        }

        .badge {
            padding: 0.5em 0.75em;
            font-weight: 500;
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
        }

        .text-primary {
            color: #0d6efd;
        }

        @media (max-width: 768px) {
            .d-flex.gap-2 {
                flex-wrap: wrap;
            }

            .btn {
                width: 100%;
                justify-content: center;
                margin-bottom: 0.5rem;
            }
        }
    </style>
@endsection
