
@extends('master')

@section('title')
    عرض الفاتورة
@stop

@section('css')
    <style>
        /* تخصيص الأزرار */
        .custom-btn {
            min-width: 120px;

            margin: 5px;

            justify-content: center;

        }

        .custom-dropdown {
            min-width: 200px;

        }


        .tab-content {
            position: relative;
            z-index: 1;
        }

        .pdf-iframe {
            width: 100%;
            height: 800px;
            border: none;
            display: block;
            margin: 0 auto;
        }

        .sidebar {
            position: fixed;
            z-index: 100;

            top: 0;
            right: 0;
            height: 100vh;
            width: 250px;

            background: #f8f9fa;
            box-shadow: -2px 0 5px rgba(0, 0, 0, 0.1);
        }

        .invoice-wrapper {

            contain: content;
            position: relative;
            z-index: 1;
            width: 100%;
            overflow: visible;
            padding: 20px 0;
        }


        .sidebar {
            position: fixed !important;
            right: 0 !important;
            top: 0 !important;
            bottom: 0 !important;
            transform: none !important;
            margin: 0 !important;
        }

        .main-content {
            transition: none !important;
            transform: none !important;
        }

        .main-content {
            margin-left: 250px;

            padding: 20px;
            width: calc(100% - 250px);
        }


        .pdf-wrapper {
            width: 100%;
            overflow-x: auto;
            background: white;
            padding: 20px;
            display: flex;
            justify-content: center;
        }


        [dir="rtl"] .pdf-wrapper {
            direction: rtl;
        }


        .tab-content>.active {
            overflow: visible !important;
        }

        .custom-dropdown .dropdown-item {
            padding: 0.5rem 1rem;

            font-size: 0.875rem;

        }

        .custom-dropdown .dropdown-item:hover {
            background-color: #f8f9fa;

            color: #0056b3;

        }


        .custom-btn i {
            margin-right: 5px;
        }

        /* تخصيصات لوحة التوقيع */
        #signature-pad {
            width: 100% !important;
            height: 200px !important;
            border: 1px solid #ddd;
            background: white;
        }

        .signature-history img {
            border: 1px solid #eee;
            padding: 5px;
            background: white;
        }

        .toast-container {
            z-index: 9999;
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
                        <span
                            class="badge badge-pill
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
                        <button onclick="printInvoice('{{ route('invoices.print', $invoice->id) }}')"
                            class="btn btn-primary btn-sm">
                            <i class="fa fa-print"></i> طباعة الفاتورة
                        </button>
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
                    <a href="{{ route('invoices.edit', $invoice->id) }}"
                        class="btn btn-sm btn-outline-danger d-flex align-items-center custom-btn">
                        <i class="fas fa-pen me-1"></i> تعديل
                    </a>

                    <!-- طباعة -->
                    <a href="{{ route('invoices.print', $invoice->id) }}"
                        class="btn btn-sm btn-outline-success d-flex align-items-center custom-btn">
                        <i class="fas fa-print me-1"></i> طباعة
                    </a>

                    <!-- PDF -->
                    <a href="{{ route('invoices.generatePdf', $invoice->id) }}"
                        class="btn btn-sm btn-outline-info d-flex align-items-center custom-btn">
                        <i class="fas fa-file-pdf me-1"></i> PDF
                    </a>

                    <!-- إضافة عملية دفع -->
                    <a href="{{ route('paymentsClient.create', ['id' => $invoice->id, 'type' => 'invoice']) }}"
                        class="btn btn-sm btn-outline-dark d-flex align-items-center custom-btn">
                        <i class="fas fa-wallet me-1"></i> إضافة عملية دفع
                    </a>

                    <!-- قسائم -->
                    <div class="btn-group">
                        <div class="dropdown">
                            <button
                                class="btn btn-sm btn-outline-warning dropdown-toggle d-flex align-items-center custom-btn"
                                type="button" id="dropdownMenuButton200" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <i class="fas fa-tags me-1"></i> القسائم
                            </button>
                            <div class="dropdown-menu custom-dropdown" aria-labelledby="dropdownMenuButton200">
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <li><a href="{{ route('invoices.label', $invoice->id) }}"
                                            class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-file-pdf me-1"></i> تحميل ملصق الطرد
                                        </a>

                                    <li><a class="dropdown-item" href="{{ route('invoices.picklist', $invoice->id) }}"><i
                                                class="fas fa-list me-1"></i> قائمة
                                            الاستلام</a></li>
                                    <li><a class="dropdown-item"
                                            href="{{ route('invoices.shipping_label', $invoice->id) }}"><i
                                                class="fas fa-truck me-1"></i> ملصق
                                            التوصيل</a></li>

                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- إضافة اتفاقية تقسيط -->
                    <a href="{{ route('installments.create', ['id' => $invoice->id]) }}"
                        class="btn btn-sm btn-outline-primary d-flex align-items-center custom-btn">
                        <i class="fas fa-handshake me-1"></i> إضافة اتفاقية تقسيط
                    </a>


                    <div class="btn-group">
                        <div class="dropdown">
                            <button
                                class="btn btn-sm btn-outline-success dropdown-toggle d-flex align-items-center custom-btn"
                                type="button" id="dropdownMenuButton200" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <i class="fas fa me-1"></i> ارسال عبر
                            </button>
                            <div class="dropdown-menu custom-dropdown" aria-labelledby="dropdownMenuButton200">
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center" target="_blank"
                                            href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $invoice->client->phone) }}?text={{ urlencode(
                                                'مرحبًا ' .
                                                    $invoice->client->trade_name .
                                                    ',' .
                                                    "\n\n" .
                                                    'يسعدنا إعلامكم بأن فاتورتكم أصبحت جاهزة. يمكنكم الاطلاع عليها من خلال الرابط التالي:' .
                                                    "\n" .
                                                    route('invoices.print', ['id' => $invoice->id, 'embed' => true]) .
                                                    "\n\n" .
                                                    'مع أطيب التحيات،' .
                                                    "\n" .
                                                    ($account_setting->trade_name ?? 'مؤسسة أعمال خاصة للتجارة'),
                                            ) }}">
                                            <i class="fab fa-whatsapp me-2 text-success"></i> واتساب
                                        </a>

                                    </li>




                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- مرتجع -->
                    <a href="{{ route('ReturnIInvoices.create', ['id' => $invoice->id]) }}"
                        class="btn btn-sm btn-outline-secondary d-flex align-items-center custom-btn">
                        <i class="fas fa-undo-alt me-1"></i> مرتجع
                    </a>

                    <!-- اشعار دائن -->
                    <a href="{{ route('CreditNotes.create', ['id' => $invoice->id]) }}"
                        class="btn btn-sm btn-outline-secondary d-flex align-items-center custom-btn">
                        <i class="fas fa-undo-alt me-1"></i> اشعار دائن
                    </a>

                    <!-- خيارات أخرى -->
                    <div class="btn-group">
                        <div class="dropdown">
                            <button
                                class="btn btn-sm btn-outline-success dropdown-toggle d-flex align-items-center custom-btn"
                                type="button" id="dropdownMenuButton200" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <i class="fas fa-cog me-1"></i> خيارات اخرى
                            </button>
                            <div class="dropdown-menu custom-dropdown" aria-labelledby="dropdownMenuButton200">
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
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
                                        <a class="dropdown-item d-flex align-items-center"
                                            href="{{ route('appointments.create') }}">
                                            <i class="fas fa-calendar-alt me-2"></i> ترتيب موعد
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center" href="#">
                                            <i class="fas fa-copy me-2"></i> نسخ
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center"
                                            href="{{ route('invoices.destroy', ['id' => $invoice->id]) }}">
                                            <i class="fas fa-trash-alt me-2"></i> حذف
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 3: Tabs -->
        <div class="card">
            <div class="card-body">
                <ul class="nav nav-tabs flex-column flex-sm-row" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="invoice-tab" data-bs-toggle="tab" data-bs-target="#invoice"
                            type="button" role="tab" aria-controls="invoice" aria-selected="true">فاتورة</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="invoice-details-tab" data-bs-toggle="tab"
                            data-bs-target="#invoice-details" type="button" role="tab"
                            aria-controls="invoice-details" aria-selected="false">تفاصيل الفاتورة</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="payments-tab" data-bs-toggle="tab" data-bs-target="#payments"
                            type="button" role="tab" aria-controls="payments"
                            aria-selected="false">مدفوعات</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="warehouse-orders-tab" data-bs-toggle="tab"
                            data-bs-target="#warehouse-orders" type="button" role="tab"
                            aria-controls="warehouse-orders" aria-selected="false">الاذون المخزني</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="activity-log-tab" data-bs-toggle="tab"
                            data-bs-target="#activity-log" type="button" role="tab" aria-controls="activity-log"
                            aria-selected="false">سجل النشاطات</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="invoice-profit-tab" data-bs-toggle="tab"
                            data-bs-target="#invoice-profit" type="button" role="tab"
                            aria-controls="invoice-profit" aria-selected="false">ربح الفاتورة</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="signature-tab-btn" data-bs-toggle="tab"
                            data-bs-target="#signature-tab" type="button" role="tab" aria-controls="signature-tab"
                            aria-selected="false">التوقيع</button>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <!-- Tab 1: Invoice -->
                    <div class="tab-pane fade show active" id="invoice" role="tabpanel" aria-labelledby="invoice-tab">
                        <iframe src="{{ route('invoices.print', ['id' => $invoice->id, 'embed' => true]) }}"
                            class="pdf-iframe" frameborder="0"></iframe>
                    </div>

                    <!-- Tab 2: Invoice Details -->
                    <div class="tab-pane fade" id="invoice-details" role="tabpanel"
                        aria-labelledby="invoice-details-tab">
                        <div id="custom-form-view">
                            <!-- محتوى تفاصيل الفاتورة -->











                        </div>

                    </div>


                    <!-- Tab 3: Payments -->
                    <div class="tab-pane fade" id="payments" role="tabpanel" aria-labelledby="payments-tab">
                        <div class="invoice-payments content-area invoice-Block">
                            <h3>
                                {{ __('عمليات الدفع على الفاتورة') }} #{{ $invoice->id }}
                                <a href="{{ route('paymentsClient.create', ['id' => $invoice->id, 'type' => 'invoice']) }}"
                                    class="btn btn-success btn-sm float-end">
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
                                                        <p class="mb-0">{{ $payment->payment_date->format('d/m/Y') }}
                                                        </p>
                                                    </div>
                                                    <div class="col-12 col-sm-4">
                                                        <small class="text-muted">{{ __('المبلغ') }}</small>
                                                        <p class="mb-0 font-weight-bold">
                                                            {{ number_format($payment->amount, 2) }} ر.س</p>
                                                    </div>
                                                    <div class="col-12 col-sm-4">
                                                        <div class="">
                                                            <small class="text-muted">{{ __('طريقة الدفع') }}</small>
                                                            @switch($payment->Payment_method)
                                                                @case(1)
                                                                    <span
                                                                        class="d-block badge badge-secondary">{{ __('نقدي') }}</span>
                                                                @break

                                                                @case(2)
                                                                    <span
                                                                        class="d-block badge badge-info">{{ __('شيك') }}</span>
                                                                @break

                                                                @case(3)
                                                                    <span
                                                                        class="d-block badge badge-primary">{{ __('تحويل بنكي') }}</span>
                                                                @break

                                                                @default
                                                                    <span
                                                                        class="d-block badge badge-light">{{ __('غير محدد') }}</span>
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
                                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle"
                                                            type="button" data-toggle="dropdown">
                                                            <i class="fa fa-ellipsis-v"></i>
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-end">
                                                            <a class="dropdown-item"
                                                                href="{{ route('paymentsClient.show', $payment->id) }}">
                                                                <i class="fa fa-eye mr-2"></i>{{ __('عرض') }}
                                                            </a>
                                                            <a class="dropdown-item"
                                                                href="{{ route('paymentsClient.edit', $payment->id) }}">
                                                                <i class="fa fa-edit mr-2"></i>{{ __('تعديل') }}
                                                            </a>
                                                            <a class="dropdown-item text-danger"
                                                                href="{{ route('paymentsClient.destroy', $payment->id) }}">
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
                                            <table class="table table-striped b-light" cellpadding="0" cellspacing="0"
                                                width="100%">
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
                                                    <td>{{ number_format($invoice->payments_process->sum('amount'), 2) }} ر.س
                                                    </td>
                                                    <td>{{ number_format($invoice->remaining_amount, 2) }} ر.س</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>





































                        <!-- Tab 4: Warehouse Orders -->
                        <div class="tab-pane fade" id="warehouse-orders" role="tabpanel"
                            aria-labelledby="warehouse-orders-tab">
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

                        <!-- Tab 7: Signature -->
                        <div class="tab-pane fade" id="signature-tab" role="tabpanel" aria-labelledby="signature-tab">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">التوقيع الإلكتروني</h4>

                                    <!-- Signature Form -->
                                    <form action="{{ route('invoices.signatures.store', $invoice->id) }}" method="POST"
                                        id="signature-form">
                                        @csrf
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label for="signer-name" class="form-label">الاسم الكامل *</label>
                                                <input type="text" name="signer_name" id="signer-name"
                                                    class="form-control" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="signer-role" class="form-label">الصفة *</label>
                                                <input type="text" name="signer_role" id="signer-role"
                                                    class="form-control" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="amount-paid" class="form-label">المبلغ المدفوع (في حالة دفع العميل)</label>
                                                <input type="number" name="amount_paid" id="amount-paid"
                                                    class="form-control" step="0.01">
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">التوقيع *</label>
                                            <div style="border: 1px dashed #ccc; height: 200px; position: relative;">
                                                <canvas id="signature-pad"
                                                    style="width: 100%; height: 100%; touch-action: none;"></canvas>
                                                <div id="signature-guide"
                                                    style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); color: #ccc; font-size: 16px; pointer-events: none;">
                                                    الرجاء التوقيع هنا
                                                </div>
                                            </div>
                                            <input type="hidden" name="signature_data" id="signature-data">
                                            <small class="text-muted">يمكنك التوقيع بإصبعك أو بالقلم</small>
                                        </div>

                                        <div class="d-flex gap-2">
                                            <button type="button" id="clear-signature" class="btn btn-danger">
                                                <i class="fas fa-eraser me-1"></i> مسح التوقيع
                                            </button>
                                            <button type="submit" id="save-signature" class="btn btn-success">
                                                <i class="fas fa-save me-1"></i> حفظ التوقيع
                                            </button>
                                        </div>
                                    </form>

                                    <!-- Signature History -->
                                    <div class="mt-4">
                                        <h5>سجل التواقيع</h5>
                                        @if ($invoice->signatures->count() > 0)
                                            @foreach ($invoice->signatures as $signature)
                                                <div class="card mb-2">
                                                    <div class="card-body">
                                                        <div class="d-flex justify-content-between">
                                                            <div>
                                                                <strong>الاسم:</strong> {{ $signature->signer_name }}
                                                                @if ($signature->signer_role)
                                                                    | <strong>الصفة:</strong> {{ $signature->signer_role }}
                                                                @endif
                                                                @if ($signature->amount_paid)
                                                                    | <strong>المبلغ المدفوع:</strong>
                                                                    {{ number_format($signature->amount_paid, 2) }} ر.س
                                                                @endif
                                                            </div>
                                                            <small>{{ $signature->created_at->format('Y-m-d H:i') }}</small>
                                                        </div>
                                                        <div class="mt-2 text-center">
                                                            <img src="{{ $signature->signature_data }}"
                                                                style="max-height: 80px; border: 1px solid #eee; background: white; padding: 5px;">
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="alert alert-info">لا توجد تواقيع مسجلة لهذه الفاتورة</div>
                                        @endif
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

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>


        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

        <script>
            $(document).ready(function() {
                // تهيئة متقدمة لـ Toastr
                toastr.options = {
                    "closeButton": true,
                    "debug": false,
                    "newestOnTop": true,
                    "progressBar": true,
                    "positionClass": "toast-top-left",
                    "preventDuplicates": true,
                    "onclick": null,
                    "showDuration": "300",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut",
                    "rtl": true,
                    "escapeHtml": true
                };

                // تهيئة متقدمة للوحة التوقيع
                const canvas = document.getElementById('signature-pad');
                const signaturePad = new SignaturePad(canvas, {
                   backgroundColor: 'rgb(255,255,255)',
    penColor: 'rgb(0,0,0)',
    minWidth: 0.7,  // أقل سمك للقلم
    maxWidth: 2,    // أقصى سمك للقلم
    throttle: 0,    // اجعل الحركة أكثر سلاسة لكن أثقل على المعالج، سنعالج ذلك في resize
                    onBegin: () => {
                        document.getElementById('signature-guide').style.display = 'none';
                    }
                });

                // ضبط حجم Canvas ليتناسب مع دقة الشاشة
                function resizeCanvas() {
    const ratio = Math.max(window.devicePixelRatio || 1, 1);

    const width = canvas.offsetWidth;
    const height = canvas.offsetHeight;

    if (width === 0 || height === 0) return;

    const data = !signaturePad.isEmpty() ? signaturePad.toData() : null;

    canvas.width = width * ratio;
    canvas.height = height * ratio;
    canvas.getContext('2d').scale(ratio, ratio);

    canvas.style.width = width + 'px';
    canvas.style.height = height + 'px';

    if (data) {
        signaturePad.fromData(data);
    }
}


                window.addEventListener('resize', resizeCanvas);
                resizeCanvas();

                // حفظ حالة التوقيع عند فقدان التركيز من الحقول
                $('input, textarea').on('focus', function() {
                    // تخزين التوقيع الحالي مؤقتاً
                    if (!signaturePad.isEmpty()) {
                        localStorage.setItem('tempSignature', signaturePad.toDataURL());
                    }
                });

                // استعادة التوقيع عند العودة
                $('input, textarea').on('blur', function() {
                    const tempSignature = localStorage.getItem('tempSignature');
                    if (tempSignature && signaturePad.isEmpty()) {
                        signaturePad.fromDataURL(tempSignature);
                        localStorage.removeItem('tempSignature');
                    }
                });

                // مسح التوقيع مع تأكيد
                document.getElementById('clear-signature').addEventListener('click', function(e) {
                    e.preventDefault();

                    if (!signaturePad.isEmpty()) {
                        Swal.fire({
                            title: 'هل أنت متأكد؟',
                            text: "سيتم مسح التوقيع الحالي تماماً!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'نعم، امسح!',
                            cancelButtonText: 'إلغاء',
                            reverseButtons: true
                        }).then((result) => {
                            if (result.isConfirmed) {
                                signaturePad.clear();
                                document.getElementById('signature-guide').style.display = 'block';
                                toastr.success('تم مسح التوقيع بنجاح', 'عملية ناجحة');
                            }
                        });
                    } else {
                        toastr.info('لا يوجد توقيع لمسحه', 'ملاحظة');
                    }
                });

                // حفظ التوقيع مع تحسينات
                document.getElementById('signature-form').addEventListener('submit', function(e) {
                    e.preventDefault();

                    const signerName = document.getElementById('signer-name').value.trim();
                    const signerRole = document.getElementById('signer-role').value.trim();
                    
                    const form = this;

                    // التحقق من الحقول المطلوبة
                    if (!signerName) {
                        toastr.error('الرجاء إدخال الاسم الكامل للموقع', 'حقل مطلوب');
                        return;
                    }

                    if (!signerRole) {
                        toastr.error('الرجاء إدخال صفة الموقع', 'حقل مطلوب');
                        return;
                    }

                    if (signaturePad.isEmpty()) {
                        toastr.error('الرجاء تقديم التوقيع أولاً', 'توقيع مطلوب');
                        return;
                    }

                    // تأكيد الحفظ
                    Swal.fire({
                        title: 'تأكيد الحفظ',
                        text: "هل أنت متأكد من حفظ هذا التوقيع؟",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#28a745',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'نعم، احفظه!',
                        cancelButtonText: 'إلغاء',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // تحويل التوقيع إلى صورة
                            const signatureData = signaturePad.toDataURL();
                            document.getElementById('signature-data').value = signatureData;

                            // إظهار تحميل
                            Swal.fire({
                                title: 'جاري الحفظ',
                                html: 'يرجى الانتظار...',
                                allowOutsideClick: false,
                                didOpen: () => {
                                    Swal.showLoading();
                                }
                            });

                            // إرسال النموذج
                            axios.post(form.action, new FormData(form))
                                .then(response => {
                                    Swal.close();
                                    if (response.data.success) {
                                        toastr.success('تم حفظ التوقيع بنجاح', 'نجاح');

                                        // إعادة تحميل الصفحة بعد ثانيتين
                                        setTimeout(() => {
                                            window.location.reload();
                                        }, 2000);
                                    } else {
                                        toastr.error(response.data.message || 'حدث خطأ أثناء الحفظ',
                                            'خطأ');
                                    }
                                })
                                .catch(error => {
                                    Swal.close();
                                    let errorMessage = 'فشل في الحفظ. يرجى المحاولة لاحقًا.';

                                    if (error.response && error.response.data && error.response.data
                                        .errors) {
                                        const errors = error.response.data.errors;
                                        errorMessage = Object.values(errors).join('<br>');
                                    }

                                    toastr.error(errorMessage, 'خطأ');
                                    console.error('Error:', error);
                                });
                        }
                    });
                });
            });
        </script>
    @endsection