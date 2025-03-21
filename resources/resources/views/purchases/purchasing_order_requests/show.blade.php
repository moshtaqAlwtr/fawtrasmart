@extends('master')

@section('title')
عرض أمر الشراء
@stop

@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">عرض أمر الشراء</h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="">الرئيسية</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('OrdersRequests.index') }}">أوامر الشراء</a></li>
                            <li class="breadcrumb-item active">عرض</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.alerts.error')
    @include('layouts.alerts.success')

    <div class="card">
        <div class="card-body p-1">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="d-flex align-items-center">
                        <h5 class="mb-0">
                            أمر شراء #{{ $purchaseOrdersRequests->code }}
                            @if ($purchaseOrdersRequests->type == 1)
                                <span class="badge bg-warning ms-2">تحت المراجعة</span>
                            @elseif ($purchaseOrdersRequests->type == 3)
                                <span class="badge bg-danger ms-2">ملغي</span>
                            @elseif ($purchaseOrdersRequests->type == 2)
                                <span class="badge bg-success ms-2">محول إلى فاتورة</span>
                            @endif
                        </h5>
                    </div>
                </div>

                <div class="d-flex gap-3">
                    @if ($purchaseOrdersRequests->type == 1)
                        <form action="{{ route('OrdersRequests.updateStatus', $purchaseOrdersRequests->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="type" value="2">
                            <button type="submit" class="btn btn-success btn-lg px-4" style="height: 48px;">
                                <i class="fas fa-check me-1"></i>
                                تحويل إلى فاتورة
                            </button>
                        </form>

                        <form action="{{ route('OrdersRequests.updateStatus', $purchaseOrdersRequests->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="type" value="3">
                            <button type="submit" class="btn btn-danger btn-lg px-4" style="height: 48px;">
                                <i class="fas fa-times me-1"></i>
                                إلغاء
                            </button>
                        </form>
                    @endif

                    @if ($purchaseOrdersRequests->type == 2)
                        <span class="badge fs-6 text-white d-flex align-items-center justify-content-center px-4"
                              style="background: linear-gradient(135deg, #43A047 0%, #2E7D32 100%); height: 48px;">
                            تم التحويل إلى فاتورة
                        </span>
                    @endif

                    @if ($purchaseOrdersRequests->type == 3)
                        <span class="badge fs-6 text-white d-flex align-items-center justify-content-center px-4"
                              style="background: linear-gradient(135deg, #d32f2f 0%, #b71c1c 100%); height: 48px;">
                            تم الإلغاء
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-title p-2 d-flex align-items-center gap-2">
            <a href="{{ route('OrdersRequests.edit', $purchaseOrdersRequests->id) }}" class="btn btn-outline-primary btn-sm">
                تعديل <i class="fa fa-edit ms-1"></i>
            </a>
            <div class="vr"></div>

            <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal"
                data-bs-target="#deleteModal">
                حذف <i class="fa fa-trash-alt ms-1"></i>
            </button>
            <div class="vr"></div>

            <div class="dropdown">
                <button class="btn btn-outline-secondary btn-sm" type="button" id="printDropdown"
                    data-bs-toggle="dropdown">
                    طباعة <i class="fa fa-print ms-1"></i>
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <a class="dropdown-item" href="">
                            <i class="fa fa-file-pdf me-2 text-danger"></i>PDF طباعة
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="#">
                            <i class="fa fa-file-excel me-2 text-success"></i>Excel تصدير
                        </a>
                    </li>
                </ul>
            </div>

            <div class="dropdown">
                <button class="btn btn-outline-info btn-sm" type="button" data-bs-toggle="dropdown">
                    المطبوعات <i class="fa fa-folder-open ms-1"></i>
                </button>
                <ul class="dropdown-menu py-1">
                    <li>
                        <a class="dropdown-item" href="">
                            <i class="fa fa-file-pdf me-2 text-danger"></i>نموذج 1
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="">
                            <i class="fa fa-file-pdf me-2 text-danger"></i>نموذج 2
                        </a>
                    </li>
                </ul>
            </div>

            <button type="button" class="btn btn-outline-warning btn-sm">
                ارسل الى المورد <i class="fa fa-envelope ms-1"></i>
            </button>

            <button type="button" class="btn btn-outline-success btn-sm">
                اضافة ملاحظة أو مرفق <i class="fa fa-paperclip ms-1"></i>
            </button>
        </div>

        <div class="card-body">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#details" role="tab">التفاصيل</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#items" role="tab">المنتجات</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#activity" role="tab">سجل النشاطات</a>
                </li>
            </ul>

            <div class="tab-content p-3">
                <div class="tab-pane active" id="details" role="tabpanel">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="tab-pane fade show active" style="background: lightslategray; min-height: 100vh; padding: 20px;">
                                <div class="card shadow" style="max-width: 600px; margin: 20px auto;">
                                    <div class="card-body bg-white p-4" style="min-height: 400px; overflow: auto;">
                                        <div style="transform: scale(0.8); transform-origin: top center;">
                                            @include('Purchases.Purchasing_order_requests.pdf', ['purchaseOrdersRequests' => $purchaseOrdersRequests])
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane" id="items" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>المنتج</th>
                                    <th>الكمية</th>
                                    <th>سعر الوحدة</th>
                                    <th>الخصم</th>
                                    <th>الضريبة</th>
                                    @if($purchaseOrdersRequests->shipping_cost > 0)
                                        <th>الشحن</th>
                                    @endif
                                    <th>الإجمالي</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($purchaseOrdersRequests->items as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->product->name ?? $item->item }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>{{ number_format($item->unit_price, 2) }}</td>
                                        <td>{{ number_format($item->discount, 2) }}</td>
                                        <td>{{ number_format($item->tax, 2) }}</td>
                                        @if($purchaseOrdersRequests->shipping_cost > 0)
                                            <td>{{ number_format($item->shipping, 2) }}</td>
                                        @endif
                                        <td>{{ number_format($item->total, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="{{ $purchaseOrdersRequests->shipping_cost > 0 ? '7' : '6' }}" class="text-start">المجموع النهائي</td>
                                    <td>{{ number_format($purchaseOrdersRequests->grand_total, 2) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <div class="tab-pane" id="activity" role="tabpanel">
                    <div class="timeline p-4">
                        <p class="text-muted text-center">لا توجد نشاطات حتى الآن</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Delete -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">حذف أمر الشراء</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>هل أنت متأكد من حذف أمر الشراء رقم "{{ $purchaseOrdersRequests->code }}"؟</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">إلغاء</button>
                    <form action="{{ route('OrdersRequests.destroy', $purchaseOrdersRequests->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">حذف</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
