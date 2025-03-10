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
                        <a href="{{ route('invoices.generatePdf', $invoice->id) }}" class="btn btn-primary">
                            <i class="fa fa-print"></i> طباعة الفاتورة
                        </a>
                    </div>
                </div>
                <div>
                    <span>المستلم: {{ $invoice->client->trade_name??'' }}</span><br>
                    <a href="#">Journal #{{ $invoice->journal_id }}</a> |
                    <a href="#">تكلفة مبيعات #{{ $invoice->sales_cost_id }}</a> - {{ $invoice->source }}
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
                            <a href="{{ route('invoices.generatePdf', $invoice->id) }}" class="btn btn-sm btn-outline-success d-inline-flex align-items-center">
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
                            <a href="{{ route('installments.create', ['id' => $invoice->id]) }}"
                                class="btn btn-sm btn-outline-primary d-inline-flex align-items-center">
                                <i class="fas fa-handshake me-1"></i> إضافة اتفاقية تقسيط
                            </a>

                            <!-- ارسال عبر -->
                            <a href="#" class="btn btn-sm btn-outline-danger d-inline-flex align-items-center">
                                <i class="fas fa-share me-1"></i> ارسال عبر
                            </a>

                            <!-- مرتجع -->
                            <a href="{{ route('ReturnIInvoices.create', ['id' => $invoice->id]) }}"
                                class="btn btn-sm btn-outline-secondary d-inline-flex align-items-center">
                                <i class="fas fa-undo-alt me-1"></i> مرتجع
                            </a>
                            <a href="{{ route('CreditNotes.create', ['id' => $invoice->id]) }}"
                                class="btn btn-sm btn-outline-secondary d-inline-flex align-items-center">
                                <i class="fas fa-undo-alt me-1"></i> اشعار دائن
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
                                            <i class="fas fa-money-bill-wave me-2"></i> <!-- أيقونة تعيين مراكز تكلفة -->
                                            تعيين مراكز تكلفة
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item d-inline-flex align-items-center" href="#">
                                            <i class="fas fa-tasks me-2"></i> <!-- أيقونة تعيين أمر شغل -->
                                            تعيين أمر شغل
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item d-inline-flex align-items-center" href="{{ route('appointment.notes.create')}}">
                                            <i class="fas fa-paperclip me-2"></i> <!-- أيقونة إضافة ملاحظة أو مرفق -->
                                            إضافة ملاحظة أو مرفق
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item d-inline-flex align-items-center" href="{{route('appointments.create')}}">
                                            <i class="fas fa-calendar-alt me-2"></i> <!-- أيقونة ترتيب موعد -->
                                            ترتيب موعد
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item d-inline-flex align-items-center" href="#">
                                            <i class="fas fa-copy me-2"></i> <!-- أيقونة نسخ -->
                                            نسخ
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item d-inline-flex align-items-center" href="{{route('invoices.destroy', ['id' => $invoice->id])}}">
                                            <i class="fas fa-trash-alt me-2"></i> <!-- أيقونة حذف -->
                                            حذف
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <a href="#" class="btn btn-sm btn-outline-danger d-inline-flex align-items-center">
                                <i class="fas fa-share me-1"></i> تحويل الى خطة انتاج
                            </a>
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

                            <!-- تفاصيل الفاتورة -->
                            <div class="tab-pane fade" id="invoice-details" role="tabpanel">
                                <div id="custom-form-view">
                                    <br>
                                    <div class="input-fields ">
                                        <h3 class="head-bar theme-color-a"><span class="details-info">
                                                هدايا مجانا </span></h3>
                                        <div class="row">



                                            <div class="col-sm-12 ">
                                                <dl class="row">

                                                    <dt class=""><strong>الوقت</strong>: </dt>
                                                    <dd class="">00:00:00</dd>
                                                </dl>


                                            </div>


                                        </div>
                                    </div>
                                    <br>


                                </div>


                            </div>

                            <!-- المدفوعات -->
                            <div class="tab-pane fade" id="payments" role="tabpanel" aria-labelledby="payments-tab">
                                <!-- InvoiceProfit -->


                                <div class="tab-pane" id="PaymentsBlock">
                                    <div class="invoice-payments content-area invoice-Block">
                                        <h3>
                                            {{ __('عمليات الدفع على الفاتورة') }} #{{ $invoice->id }}
                                            <a href="{{ route('paymentsClient.create', ['id' => $invoice->id, 'type' => 'invoice']) }}"
                                                class="btn btn-success pull-right add-payment">
                                                {{ __('إضافة عملية دفع') }}
                                            </a>
                                        </h3>
                                        <div class="clear"></div><br>


                                        <div class="card">
                                            <div class="card-body">
                                                @forelse($invoice->payments_process as $payment)
                                                    <!-- كل عملية دفع تأخذ جزءًا من الصف -->
                                                    <div class="card ">
                                                        <div class="card-body">
                                                            <div
                                                                class="d-flex justify-content-between align-items-center mb-3">
                                                                <h5 class="card-title mb-0">
                                                                    <span class="text-muted">#{{ $payment->id }}</span>
                                                                    {{ $invoice->client->trade_name }}
                                                                </h5>
                                                                @switch($payment->payment_status)
                                                                    @case(1)
                                                                        <span
                                                                            class="badge badge-success">{{ __('مكتمل') }}</span>
                                                                    @break

                                                                    @case(2)
                                                                        <span
                                                                            class="badge badge-warning">{{ __('جزئي') }}</span>
                                                                    @break

                                                                    @case(3)
                                                                        <span
                                                                            class="badge badge-danger">{{ __('غير مكتمل') }}</span>
                                                                    @break

                                                                    @default
                                                                        <span
                                                                            class="badge badge-secondary">{{ __('غير محدد') }}</span>
                                                                @endswitch
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-3">
                                                                    <small
                                                                        class="text-muted">{{ __('تاريخ الدفع') }}</small>
                                                                    <p class="mb-0">
                                                                        {{ $payment->payment_date->format('d/m/Y') }}</p>
                                                                </div>
                                                                <div class="col-3 text-left">
                                                                    <small class="text-muted">{{ __('المبلغ') }}</small>
                                                                    <p class="mb-0 font-weight-bold">
                                                                        {{ number_format($payment->amount, 2) }} ر.س</p>
                                                                </div>
                                                                <div class="col-3">
                                                                    <div class="">
                                                                        <small
                                                                            class="text-muted">{{ __('طريقة الدفع') }}</small>
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



                                                            <div class="d-flex justify-content-between align-items-center">
                                                                <div class="text-muted">
                                                                    <i class="fa fa-user mr-2"></i>
                                                                    {{ $payment->employee ? $payment->employee->full_name : __('غير محدد') }}
                                                                </div>
                                                                <div class="dropdown">
                                                                    <button
                                                                        class="btn btn-sm btn-outline-secondary dropdown-toggle"
                                                                        type="button" data-toggle="dropdown">
                                                                        <i class="fa fa-ellipsis-v"></i>
                                                                    </button>
                                                                    <div class="dropdown-menu dropdown-menu-right">
                                                                        <a class="dropdown-item"
                                                                            href="{{ route('paymentsClient.show', $payment->id) }}">
                                                                            <i
                                                                                class="fa fa-eye mr-2"></i>{{ __('عرض') }}
                                                                        </a>
                                                                        <a class="dropdown-item"
                                                                            href="{{ route('paymentsClient.edit', $payment->id) }}">
                                                                            <i
                                                                                class="fa fa-edit mr-2"></i>{{ __('تعديل') }}
                                                                        </a>
                                                                        <a class="dropdown-item text-danger"
                                                                            href="{{ route('paymentsClient.destroy', $payment->id) }}">
                                                                            <i
                                                                                class="fa fa-trash mr-2"></i>{{ __('حذف') }}
                                                                        </a>
                                                                    </div>
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


                                    </div>

                                    <div class="content-area">
                                        <div class="invoice-info">
                                            <h3>{{ __('ملخص الدفع') }}</h3>
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
                            <div class="tab-pane fade" id="warehouse-orders" role="tabpanel">
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
                            <div class="tab-pane fade" id="invoice-profit" role="tabpanel">
                                <div class="tab-pane" id="InvoiceProfit">
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
        @endsection

        @section('scripts')
            <meta name="csrf-token" content="{{ csrf_token() }}">
            <script src="{{ asset('assets/js/applmintion.js') }}"></script>
        @endsection
