@extends('master')

@section('title')
    عرض الفاتورة
@stop

@section('css')
    {{-- <link rel="stylesheet" href="{{ asset('assets/css/invoice.css') }}"> --}}


    <style>
        /* تخصيص الأزرار */
        .custom-btn {
            min-width: 120px; /* تحديد عرض ثابت للأزرار */
            margin: 5px; /* إضافة margin بقيمة 10px بين الأزرار */
            justify-content: center; /* توسيط النص والأيقونات داخل الأزرار */
        }

        /* التأكد من أن الأزرار متساوية في الارتفاع */
        .custom-btn i {
            margin-right: 5px; /* إضافة مسافة بين الأيقونة والنص */
        }
    </style>
@endsection

@section('content')
    <div class="content-body">
        <!-- Card 1: Invoice Header -->
        <div class="card mb-3">
            <div class="card-body">
                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center mb-3">
                    <div class="d-flex gap-2 mb-2 mb-sm-0">
                        <span class="badge badge-pill
                            @if ($invoice->payment_status == 1) badge-success
                            @elseif ($invoice->payment_status == 2) badge-warning
                            @elseif ($invoice->payment_status == 3) badge-danger
                            @elseif ($invoice->payment_status == 4) badge-info @endif">
                            @if ($invoice->payment_status == 1)
                                مدفوعة
                            @elseif ($invoice->payment_status == 2)
                                مدفوعة جزئيا
                            @elseif ($invoice->payment_status == 3)
                                غير مدفوعة
                            @elseif ($invoice->payment_status == 4)
                                مستلمة
                            @endif
                        </span>
                        <strong>الفاتورة #{{ $invoice->id }}</strong>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('invoices.generatePdf', $invoice->id) }}" class="btn btn-primary btn-sm">
                            <i class="fa fa-print"></i> طباعة الفاتورة
                        </a>
                    </div>
                </div>
                <div class="text-center text-sm-start">
                    <span>المستلم: {{ $invoice->client->trade_name ?? '' }}</span><br>
                    <a href="#">Journal #{{ $invoice->journal_id }}</a> |
                    <a href="#">تكلفة مبيعات #{{ $invoice->sales_cost_id }}</a> - {{ $invoice->source }}
                </div>
            </div>
        </div>

        <!-- Card 2: Actions -->
        <div class="card mb-3">
            <div class="card-body">
                <div class="d-flex flex-column flex-sm-row gap-2 justify-content-between align-items-center">
                    <!-- تعديل -->
                    <a href="{{ route('invoices.edit', $invoice->id) }}" class="btn btn-sm btn-outline-danger d-flex align-items-center custom-btn">
                        <i class="fas fa-pen me-1"></i> تعديل
                    </a>

                    <!-- طباعة -->
                    <a href="{{ route('invoices.generatePdf', $invoice->id) }}" class="btn btn-sm btn-outline-success d-flex align-items-center custom-btn">
                        <i class="fas fa-print me-1"></i> طباعة
                    </a>

                    <!-- PDF -->
                    <a href="{{ route('invoices.generatePdf', $invoice->id) }}" class="btn btn-sm btn-outline-info d-flex align-items-center custom-btn">
                        <i class="fas fa-file-pdf me-1"></i> PDF
                    </a>

                    <!-- إضافة عملية دفع -->
                    <a href="{{ route('paymentsClient.create', ['id' => $invoice->id, 'type' => 'invoice']) }}" class="btn btn-sm btn-outline-dark d-flex align-items-center custom-btn">
                        <i class="fas fa-wallet me-1"></i> إضافة عملية دفع
                    </a>

                    <!-- قسائم -->
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-warning d-flex align-items-center custom-btn dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-ticket-alt me-1"></i> قسائم
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <li><a class="dropdown-item" href="#"><i class="fas fa-tag me-1"></i> ملصق الطرد</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-list me-1"></i> قائمة الإسلام</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-truck me-1"></i> ملصق الشحن</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-file-invoice me-1"></i> فاتورة حرارية</a></li>
                        </ul>
                    </div>

                    <!-- إضافة اتفاقية تقسيط -->
                    <a href="{{ route('installments.create', ['id' => $invoice->id]) }}" class="btn btn-sm btn-outline-primary d-flex align-items-center custom-btn">
                        <i class="fas fa-handshake me-1"></i> إضافة اتفاقية تقسيط
                    </a>

                    <!-- ارسال عبر -->
                    <a href="#" class="btn btn-sm btn-outline-danger d-flex align-items-center custom-btn">
                        <i class="fas fa-share me-1"></i> ارسال عبر
                    </a>

                    <!-- مرتجع -->
                    <a href="{{ route('ReturnIInvoices.create', ['id' => $invoice->id]) }}" class="btn btn-sm btn-outline-secondary d-flex align-items-center custom-btn">
                        <i class="fas fa-undo-alt me-1"></i> مرتجع
                    </a>

                    <!-- اشعار دائن -->
                    <a href="{{ route('CreditNotes.create', ['id' => $invoice->id]) }}" class="btn btn-sm btn-outline-secondary d-flex align-items-center custom-btn">
                        <i class="fas fa-undo-alt me-1"></i> اشعار دائن
                    </a>

                    <!-- خيارات أخرى -->
                    <div class="dropdown">
                        <button type="button" class="btn btn-sm btn-outline-dark d-flex align-items-center custom-btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            خيارات أخرى
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <i class="fas fa-money-bill-wave me-2"></i> تعيين مراكز تكلفة
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <i class="fas fa-tasks me-2"></i> تعيين أمر شغل
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="{{ route('appointments.create') }}">
                                    <i class="fas fa-calendar-alt me-2"></i> ترتيب موعد
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <i class="fas fa-copy me-2"></i> نسخ
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="{{ route('invoices.destroy', ['id' => $invoice->id]) }}">
                                    <i class="fas fa-trash-alt me-2"></i> حذف
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 3: Tabs -->
        <div class="card">
            <div class="card-body">
                <ul class="nav nav-tabs flex-column flex-sm-row" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="invoice-tab" data-bs-toggle="tab" data-bs-target="#invoice" type="button" role="tab" aria-controls="invoice" aria-selected="true">فاتورة</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="invoice-details-tab" data-bs-toggle="tab" data-bs-target="#invoice-details" type="button" role="tab" aria-controls="invoice-details" aria-selected="false">تفاصيل الفاتورة</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="payments-tab" data-bs-toggle="tab" data-bs-target="#payments" type="button" role="tab" aria-controls="payments" aria-selected="false">مدفوعات</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="warehouse-orders-tab" data-bs-toggle="tab" data-bs-target="#warehouse-orders" type="button" role="tab" aria-controls="warehouse-orders" aria-selected="false">الاذون المخزني</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="activity-log-tab" data-bs-toggle="tab" data-bs-target="#activity-log" type="button" role="tab" aria-controls="activity-log" aria-selected="false">سجل النشاطات</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="invoice-profit-tab" data-bs-toggle="tab" data-bs-target="#invoice-profit" type="button" role="tab" aria-controls="invoice-profit" aria-selected="false">ربح الفاتورة</button>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <!-- Tab 1: Invoice -->
                    <div class="tab-pane fade show active" id="invoice" role="tabpanel" aria-labelledby="invoice-tab">
                        @include('sales.invoices.pdf', ['invoice' => $invoice])
                    </div>

                    <!-- Tab 2: Invoice Details -->
                    <div class="tab-pane fade" id="invoice-details" role="tabpanel" aria-labelledby="invoice-details-tab">
                        <div id="custom-form-view">
                            <br>
                            <div class="input-fields">
                                <h3 class="head-bar theme-color-a"><span class="details-info">هدايا مجانا</span></h3>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <dl class="row">
                                            <dt><strong>الوقت</strong>:</dt>
                                            <dd>00:00:00</dd>
                                        </dl>
                                    </div>
                                </div>
                            </div>
                            <br>
                        </div>
                    </div>

                    <!-- Tab 3: Payments -->
                    <div class="tab-pane fade" id="payments" role="tabpanel" aria-labelledby="payments-tab">
                        <div class="invoice-payments content-area invoice-Block">
                            <h3>
                                {{ __('عمليات الدفع على الفاتورة') }} #{{ $invoice->id }}
                                <a href="{{ route('paymentsClient.create', ['id' => $invoice->id, 'type' => 'invoice']) }}" class="btn btn-success btn-sm float-end">
                                    {{ __('إضافة عملية دفع') }}
                                </a>
                            </h3>
                            <div class="clear"></div><br>

                            <div class="card">
                                <div class="card-body">
                                    @forelse($invoice->payments_process as $payment)
                                        <div class="card mb-3">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between align-items-center mb-3">
                                                    <h5 class="card-title mb-0">
                                                        <span class="text-muted">#{{ $payment->id }}</span>
                                                        {{ $invoice->client->trade_name }}
                                                    </h5>
                                                    @switch($payment->payment_status)
                                                        @case(1)
                                                            <span class="badge badge-success">{{ __('مكتمل') }}</span>
                                                        @break

                                                        @case(2)
                                                            <span class="badge badge-warning">{{ __('جزئي') }}</span>
                                                        @break

                                                        @case(3)
                                                            <span class="badge badge-danger">{{ __('غير مكتمل') }}</span>
                                                        @break

                                                        @default
                                                            <span class="badge badge-secondary">{{ __('غير محدد') }}</span>
                                                    @endswitch
                                                </div>

                                                <div class="row">
                                                    <div class="col-12 col-sm-4">
                                                        <small class="text-muted">{{ __('تاريخ الدفع') }}</small>
                                                        <p class="mb-0">{{ $payment->payment_date->format('d/m/Y') }}</p>
                                                    </div>
                                                    <div class="col-12 col-sm-4">
                                                        <small class="text-muted">{{ __('المبلغ') }}</small>
                                                        <p class="mb-0 font-weight-bold">{{ number_format($payment->amount, 2) }} ر.س</p>
                                                    </div>
                                                    <div class="col-12 col-sm-4">
                                                        <div class="">
                                                            <small class="text-muted">{{ __('طريقة الدفع') }}</small>
                                                            @switch($payment->Payment_method)
                                                                @case(1)
                                                                    <span class="d-block badge badge-secondary">{{ __('نقدي') }}</span>
                                                                @break

                                                                @case(2)
                                                                    <span class="d-block badge badge-info">{{ __('شيك') }}</span>
                                                                @break

                                                                @case(3)
                                                                    <span class="d-block badge badge-primary">{{ __('تحويل بنكي') }}</span>
                                                                @break

                                                                @default
                                                                    <span class="d-block badge badge-light">{{ __('غير محدد') }}</span>
                                                            @endswitch
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="d-flex justify-content-between align-items-center mt-3">
                                                    <div class="text-muted">
                                                        <i class="fa fa-user mr-2"></i>
                                                        {{ $payment->employee ? $payment->employee->full_name : __('غير محدد') }}
                                                    </div>
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown">
                                                            <i class="fa fa-ellipsis-v"></i>
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-end">
                                                            <a class="dropdown-item" href="{{ route('paymentsClient.show', $payment->id) }}">
                                                                <i class="fa fa-eye mr-2"></i>{{ __('عرض') }}
                                                            </a>
                                                            <a class="dropdown-item" href="{{ route('paymentsClient.edit', $payment->id) }}">
                                                                <i class="fa fa-edit mr-2"></i>{{ __('تعديل') }}
                                                            </a>
                                                            <a class="dropdown-item text-danger" href="{{ route('paymentsClient.destroy', $payment->id) }}">
                                                                <i class="fa fa-trash mr-2"></i>{{ __('حذف') }}
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="col-12">
                                            <div class="alert alert-info text-center">
                                                {{ __('لا توجد عمليات دفع لهذه الفاتورة') }}
                                            </div>
                                        </div>
                                    @endforelse
                                </div>
                            </div>

                            <div class="content-area">
                                <div class="invoice-info">
                                    <h3>{{ __('ملخص الدفع') }}</h3>
                                    <div class="table-responsive">
                                        <table class="table table-striped b-light" cellpadding="0" cellspacing="0" width="100%">
                                            <tr>
                                                <th>{{ __('رقم الفاتورة') }}</th>
                                                <th>{{ __('العملة') }}</th>
                                                <th>{{ __('إجمالي الفاتورة') }}</th>
                                                <th>{{ __('مرتجع') }}</th>
                                                <th>{{ __('المدفوع') }}</th>
                                                <th>{{ __('الباقي') }}</th>
                                            </tr>
                                            <tr>
                                                <td>{{ $invoice->id }}</td>
                                                <td>{{ $invoice->currency ?? 'SAR' }}</td>
                                                <td>{{ number_format($invoice->grand_total, 2) }} ر.س</td>
                                                <td>{{ number_format($invoice->return_amount ?? 0, 2) }} ر.س</td>
                                                <td>{{ number_format($invoice->payments_process->sum('amount'), 2) }} ر.س</td>
                                                <td>{{ number_format($invoice->remaining_amount, 2) }} ر.س</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tab 4: Warehouse Orders -->
                    <div class="tab-pane fade" id="warehouse-orders" role="tabpanel" aria-labelledby="warehouse-orders-tab">
                        <div class="table-responsive">
                            <table class="table table-striped b-light" cellpadding="0" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>{{ __('اسم المنتج') }}</th>
                                        <th>{{ __('الكمية') }}</th>
                                        <th>{{ __('رصيد المخزون') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($invoice->items as $item)
                                        <tr>
                                            <td>{{ $item->product->name ?? __('غير متوفر') }}</td>
                                            <td>{{ $item->quantity }}</td>
                                            <td>{{ $item->product->product_details->quantity }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center">
                                                {{ __('لا توجد عناصر في الفاتورة') }}
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Tab 5: Activity Log -->
                    <div class="tab-pane fade" id="activity-log" role="tabpanel" aria-labelledby="activity-log-tab">
                        <p>سجل النشاطات سيظهر هنا.</p>
                    </div>

                    <!-- Tab 6: Invoice Profit -->
                    <div class="tab-pane fade" id="invoice-profit" role="tabpanel" aria-labelledby="invoice-profit-tab">
                        <div class="tab-pane" id="InvoiceProfit">
                            <div class="table-responsive">
                                <table class="list-table table table-hover tableClass">
                                    <thead>
                                        <tr>
                                            <th>{{ __('الاسم') }}</th>
                                            <th>{{ __('الكمية') }}</th>
                                            <th>{{ __('سعر البيع') }}</th>
                                            <th>{{ __('متوسط السعر') }}</th>
                                            <th>{{ __('الربح') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($invoice->items as $item)
                                            <tr>
                                                <td>
                                                    #{{ $item->id }} {{ $item->product->name }}
                                                    <div class="store_handle"></div>
                                                </td>
                                                <td>{{ $item->quantity }}</td>
                                                <td>
                                                    @if ($item->product)
                                                        {{ number_format($item->product->sale_price, 2) }} ر.س
                                                    @else
                                                        {{ __('غير متوفر') }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($item->product)
                                                        {{ number_format($item->product->purchase_price, 2) }} ر.س
                                                    @else
                                                        {{ __('غير متوفر') }}
                                                    @endif
                                                </td>
                                                <td>
                                                    <span dir="ltr">
                                                        @if ($item->product)
                                                            {{ number_format(($item->product->sale_price - $item->product->purchase_price) * $item->quantity, 2) }}
                                                        @else
                                                            {{ __('غير متوفر') }}
                                                        @endif
                                                    </span> ر.س
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center">
                                                    {{ __('لا توجد عناصر في الفاتورة') }}
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="4">{{ __('الإجمالي') }}</td>
                                            <td>
                                                <b>
                                                    <span dir="ltr">
                                                        {{ number_format(
                                                            $invoice->items->sum(function ($item) {
                                                                return $item->product ? ($item->product->sale_price - $item->product->purchase_price) * $item->quantity : 0;
                                                            }),
                                                            2,
                                                        ) }}
                                                    </span> ر.س
                                                </b>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
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
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
@endsection
