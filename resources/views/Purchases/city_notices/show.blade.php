@extends('master')

@section('title')
إشعار دائن #{{ $cityNotice->invoice_number }}
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <div class="content-header d-flex justify-content-between align-items-center mb-2">
            <div>
                <h2 class="content-header-title mb-0">
                    إشعار دائن {{ $cityNotice->invoice_number }}
                    <span class="badge {{ $cityNotice->status == 1 ? 'bg-success' : 'bg-warning' }}">
                        {{ $cityNotice->status == 1 ? 'نشط' : 'غير نشط' }}
                    </span>
                </h2>
                <small>المورد: {{ optional($cityNotice->supplier)->trade_name }} - رقم الإشعار #{{ $cityNotice->invoice_number }}</small>
            </div>
            <div>
                <button type="button" class="btn btn-success" onclick="window.print()">
                    <i class="fas fa-print"></i> طباعة
                </button>
            </div>
        </div>


        </div>
    </div>
</div>
    @if(session()->has('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-header p-2">
            <div class="d-flex gap-2">
                <!-- مجموعة الأزرار الأولى -->
                <div class="btn-group">
                    <a href="{{ route('CityNotices.edit', $cityNotice->id) }}" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-edit"></i> تعديل
                    </a>
                    <button type="button" class="btn btn-outline-primary btn-sm" onclick="sendToSupplier()">
                        <i class="fas fa-envelope"></i> إرسال للمورد
                    </button>
                </div>

                <!-- مجموعة الأزرار الثانية -->
                <div class="btn-group">
                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="addNote()">
                        <i class="fas fa-sticky-note"></i> إضافة ملاحظة/مرفق
                    </button>
                    <div class="btn-group">
                        <button type="button" class="btn btn-outline-secondary btn-sm dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="fas fa-print"></i> طباعة
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#"><i class="fas fa-file-pdf text-danger me-2"></i>PDF</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-file-excel text-success me-2"></i>Excel</a></li>
                        </ul>
                    </div>
                </div>

                <!-- مجموعة الأزرار الثالثة -->
                <div class="btn-group">
                    <div class="dropdown">
                        <button type="button" class="btn btn-outline-info btn-sm dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="fas fa-ellipsis-v"></i> قائمة
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#"><i class="fas fa-clone me-2"></i>نسخ</a></li>
                            <li><a class="dropdown-item text-danger" href="#" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                <i class="fas fa-trash-alt me-2"></i>حذف
                            </a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" href="#invoice" data-bs-toggle="tab">الإشعار الدائن</a>
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
                                                    @include('Purchases.city_notices.pdf', ['cityNotice' => $cityNotice])
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
                                    @foreach ($cityNotice->items as $item)
                                        <tr>
                                            <td>{{ optional($item->product)->name }}</td>
                                            <td>{{ $item->quantity }}</td>
                                            <td>{{ $item->unit_price }}</td>
                                            <td>{{ $item->total }}</td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="attachments">
                    <div class="p-3">
                        @if($cityNotice->attachments)
                            <div class="mb-3">
                                <h5>المرفقات الحالية:</h5>
                                <a href="{{ asset('assets/uploads/' . $cityNotice->attachments) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-file"></i> عرض المرفق
                                </a>
                            </div>
                        @else
                            <p>لا توجد مرفقات</p>
                        @endif
                    </div>
                </div>

                <div class="tab-pane fade" id="activity">
                    <div class="p-3">
                        <p>سجل النشاطات سيظهر هنا</p>
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
                    <h5 class="modal-title">حذف الإشعار</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>هل أنت متأكد من حذف الإشعار الدائن رقم "{{ $cityNotice->invoice_number }}"؟</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">إلغاء</button>
                    <form action="{{ route('CityNotices.destroy', $cityNotice->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">حذف</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
