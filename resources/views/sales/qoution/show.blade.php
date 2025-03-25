@extends('master')

@section('title')
    عرض عرض الأسعار
@stop

@section('content')

@include('layouts.alerts.error')
@include('layouts.alerts.success')
    <div class="content-body">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="d-flex gap-2">
                        <span class="badge badge-pill badge-warning">تحت المراجعة</span>
                        <strong> عرض الأسعار #{{ $quote->id }}</strong>
                        <span>العميل: {{ $quote->client->trade_name }}</span>
                    </div>
                    <div class="d-flex gap-2">
                        <form action="{{ route('questions.convertToInvoice', $quote->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-success d-inline-flex align-items-center">
                                <i class="fas fa-dollar-sign me-1"></i> تحويل لفاتورة
                            </button>
                        </form>
                        <button class="btn btn-sm btn-success d-inline-flex align-items-center">
                            <i class="fas fa-print me-1"></i> طباعة عرض الأسعار
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <div class="d-flex gap-2">
                        <!-- تعديل -->
                        <a href="{{ route('questions.edit', $quote->id) }}"
                            class="btn btn-sm btn-outline-danger d-inline-flex align-items-center">
                            <i class="fas fa-pen me-1"></i> تعديل
                        </a>

                        <!-- طباعة -->
                        <a href="#" class="btn btn-sm btn-outline-success d-inline-flex align-items-center">
                            <i class="fas fa-print me-1"></i> طباعة
                        </a>

                        <!-- PDF -->
                        <a href=""
                            class="btn btn-sm btn-outline-info d-inline-flex align-items-center">
                            <i class="fas fa-file-pdf me-1"></i> PDF
                        </a>

                        <!-- إرسال عبر -->
                        <a href="#" class="btn btn-sm btn-outline-dark d-inline-flex align-items-center">
                            <i class="fas fa-share me-1"></i> إرسال عبر
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
                                        <i class="fas fa-copy me-2"></i>
                                        نسخ عرض الأسعار
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item d-inline-flex align-items-center" href="#">
                                        <i class="fas fa-trash me-2"></i>
                                        حذف عرض الأسعار
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <ul class="nav nav-tabs mt-3" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="quote-tab" data-toggle="tab" href="#quote" role="tab"
                                    aria-controls="quote" aria-selected="true">عرض الأسعار</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="quote-details-tab" data-toggle="tab" href="#quote-details"
                                    role="tab" aria-controls="quote-details" aria-selected="false">تفاصيل عرض الأسعار</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="activity-log-tab" data-toggle="tab" href="#activity-log"
                                    role="tab" aria-controls="activity-log" aria-selected="false">سجل النشاطات</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade show active d-flex justify-content-center align-items-center"
                                id="quote" role="tabpanel" aria-labelledby="quote-tab" style="height: 100%;">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="tab-pane fade show active"
                                            style="background: lightslategray; min-height: 100vh; padding: 20px;">
                                            <div class="card shadow" style="max-width: 600px; margin: 20px auto;">
                                                <div class="card-body bg-white p-4"
                                                    style="min-height: 400px; overflow: auto;">
                                                    <div style="transform: scale(0.8); transform-origin: top center;">
                                                        @include('sales.qoution.pdf', [
                                                            'quote' => $quote,
                                                        ])
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="quote-details" role="tabpanel"
                                aria-labelledby="quote-details-tab">
                                <div class="table-responsive">
                                    <table class="table table-hover table-bordered">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>المنتج</th>
                                                <th>الكمية</th>
                                                <th>سعر الوحدة</th>
                                                <th>الإجمالي</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($quote->items as $item)
                                                <tr>
                                                    <td>{{ $item->product->name }}</td>
                                                    <td>{{ $item->quantity }}</td>
                                                    <td>{{ $item->price }}</td>
                                                    <td>{{ $item->total }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="activity-log" role="tabpanel"
                                aria-labelledby="activity-log-tab">
                                <div class="activity-item">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <span class="badge badge-pill badge-success">{{ $quote->created_at->format('d M') }}</span>
                                            <p class="mb-0 ml-2">أنشأ {{ $quote->employee->name ?? "" }} عرض الأسعار رقم <strong>#{{ $quote->id }}</strong>
                                                للعميل <strong>{{ $quote->client->trade_name ?? "" }}</strong> بإجمالي
                                                <strong>{{ $quote->total }}</strong></p>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <span class="mr-2">{{ $quote->created_at->format('H:i:s') ?? "" }} - {{ $quote->employee->name ?? "" }}</span>
                                            <span class="badge badge-pill badge-info">Main Branch</span>
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
    @section('scripts')
    <script>
        function convertToInvoice(quoteId) {
            if (confirm('هل أنت متأكد من تحويل عرض الأسعار إلى فاتورة؟')) {
                fetch(`/quotes/${quoteId}/convert-to-invoice`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('تم تحويل عرض الأسعار إلى فاتورة بنجاح!');
                        window.location.href = '/invoices/' + data.invoice_id; // توجيه المستخدم إلى صفحة الفاتورة
                    } else {
                        alert('حدث خطأ أثناء التحويل: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('حدث خطأ أثناء التحويل.');
                });
            }
        }
    </script>
@endsection
@endsection
