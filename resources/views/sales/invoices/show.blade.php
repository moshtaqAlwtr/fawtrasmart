@extends('master')

@section('title')
    عرض الفاتورة
@stop

@section('content')

    <div class="content-body">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="d-flex gap-2">
                        <span class="badge badge-pill badge-warning">غير مدفوعة </span>
                        <strong> الفاتورة #{{ $invoice->id }}</strong>
                        <span>المستلم: {{ $invoice->client->trade_name }}</span>
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-sm btn-success d-inline-flex align-items-center">
                            <i class="fas fa-dollar-sign me-1"></i> تحويل لفاتورة
                        </button>
                        <button class="btn btn-sm btn-success d-inline-flex align-items-center">
                            <i class="fas fa-print me-1"></i> طباعة الفاتورة
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="d-flex gap-2">
                            <!-- تعديل -->
                            <a href="{{ route('invoices.edit', $invoice->id) }}"
                                class="btn btn-sm btn-outline-danger d-inline-flex align-items-center">
                                <i class="fas fa-pen me-1"></i> تعديل
                            </a>

                            <!-- طباعة -->
                            <a href="#" class="btn btn-sm btn-outline-success d-inline-flex align-items-center">
                                <i class="fas fa-print me-1"></i> طباعة
                            </a>

                            <!-- PDF -->
                            <a href="{{ route('invoices.generatePdf', $invoice->id) }}"
                                class="btn btn-sm btn-outline-info d-inline-flex align-items-center">
                                <i class="fas fa-file-pdf me-1"></i> PDF
                            </a>

                            <!-- إضافة عملية دفع -->
                            <a href="{{ route('paymentsClient.create', ['id' => $invoice->id, 'type' => 'invoice']) }}"
                                class="btn btn-sm btn-outline-dark d-inline-flex align-items-center">
                                <i class="fas fa-wallet me-1"></i> إضافة عملية دفع
                             </a>

                            <!-- قسائم -->
                            <a href="" class="btn btn-sm btn-outline-warning d-inline-flex align-items-center">
                                <i class="fas fa-ticket-alt me-1"></i> قسائم
                            </a>

                            <!-- إضافة اتفاقية تقسيط -->
                            <a href="{{ route('installments.create', ['id' => $invoice->id]) }}" class="btn btn-sm btn-outline-primary d-inline-flex align-items-center">
                                <i class="fas fa-handshake me-1"></i> إضافة اتفاقية تقسيط
                            </a>

                            <!-- ارسال عبر -->
                            <a href="#" class="btn btn-sm btn-outline-danger d-inline-flex align-items-center">
                                <i class="fas fa-share me-1"></i> ارسال عبر
                            </a>

                            <!-- مرتجع -->
                            <a href="{{ route('ReturnIInvoices.create', ['id' => $invoice->id]) }}" class="btn btn-sm btn-outline-secondary d-inline-flex align-items-center">
                                <i class="fas fa-undo-alt me-1"></i> مرتجع
                            </a>
                            <!-- خيارات أخرى -->
                            <div class="dropdown">
                                <button type="button" class="btn btn-sm btn-outline-dark dropdown-toggle"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    خيارات أخرى
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item d-inline-flex align-items-center" href="#">
                                            <i class="fas fa-credit-card me-2"></i>
                                            أضف رصيد مدفوعات
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <ul class="nav nav-tabs mt-3" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="invoice-tab" data-toggle="tab" href="#invoice" role="tab"
                                    aria-controls="invoice" aria-selected="true">فاتورة</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="invoice-details-tab" data-toggle="tab" href="#invoice-details"
                                    role="tab" aria-controls="invoice-details" aria-selected="false">تفاصيل الفاتورة</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="payments-tab" data-toggle="tab" href="#payments" role="tab"
                                    aria-controls="payments" aria-selected="false">مدفوعات</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="warehouse-orders-tab" data-toggle="tab" href="#warehouse-orders"
                                    role="tab" aria-controls="warehouse-orders" aria-selected="false">الاذون المخزني</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="activity-log-tab" data-toggle="tab" href="#activity-log"
                                    role="tab" aria-controls="activity-log" aria-selected="false">سجل النشاطات</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="invoice-profit-tab" data-toggle="tab" href="#invoice-profit"
                                    role="tab" aria-controls="invoice-profit" aria-selected="false">ربح الفاتورة</a>
                            </li>

                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade show active d-flex justify-content-center align-items-center"
                                id="invoice" role="tabpanel" aria-labelledby="invoice-tab" style="height: 100%;">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="tab-pane fade show active"
                                            style="background: lightslategray; min-height: 100vh; padding: 20px;">
                                            <div class="card shadow" style="max-width: 100%; margin: 20px auto;">
                                                <div class="card-body bg-white p-4"
                                                    style="min-height: 400px; overflow: auto;">
                                                    <!-- إزالة التحجيم وإضافة تصميم الفاتورة -->
                                                    <div style="width: 100%;">
                                                        @include('sales.invoices.pdf', [
                                                            'invoice' => $invoice,
                                                        ])
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
    </div>
    </div>
@endsection

@section('scripts')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{ asset('assets/js/applmintion.js') }}"></script>
@endsection
