@extends('master')

@section('title')
فاتورة الشراء #{{ $purchaseInvoice->code }}
@stop

@section('content')

    <div class="content-header d-flex justify-content-between align-items-center mb-2">
        <div>
            <h2 class="content-header-title mb-0">
                فاتورة الشراء {{ $purchaseInvoice->code }}
                <span class="badge {{ $purchaseInvoice->status == 1 ? 'bg-warning' : 'bg-success' }}">
                    {{ $purchaseInvoice->status == 1 ? 'مدفوعة' : 'مستلم' }}
                </span>
            </h2>
            <small>المورد: {{ $purchaseInvoice->supplier->name }} - Journal #{{ $purchaseInvoice->code }}</small>
        </div>
    </div>

    @if(session()->has('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> تم حفظ فاتورة الشراء
        </div>
    @endif

    <div class="card">
        <div class="card-header p-2">
            <div class="d-flex gap-2">
                <a href="" class="btn btn-outline-info btn-sm">
                    <i class="fas fa-edit"></i> تعديل
                </a>

                <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal">
                    <i class="fas fa-trash"></i> حذف
                </button>

                <a href="#" class="btn btn-outline-warning btn-sm">
                    <i class="fas fa-file-pdf"></i> PDF باركود
                </a>

                <a href="#" class="btn btn-outline-success btn-sm">
                    <i class="fas fa-file-pdf"></i> PDF
                </a>

                <button type="button" class="btn btn-outline-primary btn-sm">
                    <i class="fas fa-print"></i> طباعة
                </button>

                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="assignCostCenter()">
                    <i class="fas fa-building"></i> تعيين مراكز التكلفة
                </button>

                <div class="btn-group">
                    <button type="button" class="btn btn-outline-dark btn-sm dropdown-toggle" data-bs-toggle="dropdown">
                        <i class="fas fa-list"></i> قسائم
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#"><i class="fas fa-plus me-2"></i>إضافة قسيمة</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-list me-2"></i>عرض القسائم</a></li>
                    </ul>
                </div>

                <button type="button" class="btn btn-outline-info btn-sm" onclick="addNote()">
                    <i class="fas fa-sticky-note"></i> إضافة ملاحظة/مرفق
                </button>

                <a href="{{route('PaymentSupplier.createPurchase',$purchaseInvoice->id )}}" type="button" class="btn btn-outline-success btn-sm" onclick="addPayment()">
                    <i class="fas fa-money-bill"></i> إضافة عملية دفع
                </a>
            </div>
        </div>

        <div class="card-body">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" href="#invoice" data-bs-toggle="tab">فاتورة شراء</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#payments" data-bs-toggle="tab">المدفوعات</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#attachments" data-bs-toggle="tab">المرفقات</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#activity" data-bs-toggle="tab">سجل النشاطات</a>
                </li>
            </ul>

            <div class="tab-content mt-3">
                <div class="tab-pane fade show active" id="invoice">
                    <div class="tab-content p-3">
                        <div class="tab-pane active" id="details" role="tabpanel">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="tab-pane fade show active" style="background: lightslategray; min-height: 100vh; padding: 20px;">
                                        <div class="card shadow" style="max-width: 600px; margin: 20px auto;">
                                            <div class="card-body bg-white p-4" style="min-height: 400px; overflow: auto;">
                                                <div style="transform: scale(0.8); transform-origin: top center;">
                                                    @include('Purchases.Invoices_purchase.pdf', ['purchaseInvoice' => $purchaseInvoice])
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- تبويب المنتجات -->
                        <div class="tab-pane" id="items" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <!-- نفس الجدول مع تغيير المتغير -->
                                    @foreach ($purchaseInvoice->items as $item)
                                        <tr>
                                            <!-- نفس البيانات -->
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- باقي التبويبات -->
            </div>
        </div>
    </div>

    <!-- Modal Delete -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">حذف الفاتورة</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>هل أنت متأكد من حذف الفاتورة رقم "{{ $purchaseInvoice->code }}"؟</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">إلغاء</button>
                    <form action="{{ route('invoicePurchases.destroy', $purchaseInvoice->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">حذف</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Payment -->
    <div class="modal fade" id="paymentModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">إضافة دفعة جديدة</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">المبلغ</label>
                            <input type="number" name="amount" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">طريقة الدفع</label>
                            <select name="payment_method" class="form-select" required>
                                <option value="cash">نقداً</option>
                                <option value="bank">تحويل بنكي</option>
                                <option value="check">شيك</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">ملاحظات</label>
                            <textarea name="notes" class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">إلغاء</button>
                        <button type="submit" class="btn btn-primary">حفظ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
