@extends('master')

@section('title')
    عرض طلب شراء
@stop

@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">عرض طلب شراء</h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="">الرئيسية</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('OrdersPurchases.index') }}">طلبات الشراء</a></li>
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
                <!-- الجانب الأيمن - حالة الطلب والرقم -->
                <div class="d-flex align-items-center gap-3">
                    <h5 class="mb-0">طلب شراء {{ $purchaseOrder->id }} #{{ $purchaseOrder->code }}</h5>
                    <div class="d-flex align-items-center gap-2">
                        <i class="fas fa-circle text-warning" style="font-size: 8px;"></i>
                        @if ($purchaseOrder->status == 1)
                            <span class="badge bg-warning">تحت المراجعة </span>
                        @elseif ($purchaseOrder->status == 2)
                            <span class="badge bg-success">تم الموافقة علية </span>
                        @elseif ($purchaseOrder->status == 3)
                            <span class="badge bg-danger">مرفوض</span>
                        @endif
                    </div>
                </div>

                <!-- الجانب الأيسر - أزرار الموافقة والرفض -->
                <div class="d-flex align-items-center gap-2">
                    <button type="button" class="btn btn-success d-flex align-items-center gap-2" data-bs-toggle="modal"
                        data-bs-target="#approveModal">
                        <i class="fas fa-check"></i>
                        <span>موافقة</span>
                    </button>

                    <button type="button" class="btn btn-danger d-flex align-items-center gap-2" data-bs-toggle="modal"
                        data-bs-target="#rejectModal">
                        <i class="fas fa-times"></i>
                        <span>رفض</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal للموافقة -->
    <div class="modal fade" id="approveModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('OrdersPurchases.approve', $purchaseOrder->id) }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">تأكيد الموافقة</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p>هل أنت متأكد من الموافقة على طلب الشراء رقم {{ $purchaseOrder->code }}؟</p>
                        <div class="mb-3">
                            <label for="approveNote" class="form-label">ملاحظات (اختياري)</label>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">إلغاء</button>
                        <button type="submit" class="btn btn-success">تأكيد الموافقة</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal للرفض -->
    <div class="modal fade" id="rejectModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('OrdersPurchases.reject', $purchaseOrder->id) }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">تأكيد الرفض</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p>هل أنت متأكد من رفض طلب الشراء رقم {{ $purchaseOrder->code }}؟</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">إلغاء</button>
                        <button type="submit" class="btn btn-danger">تأكيد الرفض</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-title p-2 d-flex align-items-center gap-2">
            <a href="{{ route('OrdersPurchases.edit', $purchaseOrder->id) }}" class="btn btn-outline-primary btn-sm">
                تعديل <i class="fa fa-edit ms-1"></i>
            </a>
            <div class="vr"></div>

            <a href="#" class="btn btn-outline-info btn-sm">
                نسخ <i class="fa fa-copy ms-1"></i>
            </a>
            <div class="vr"></div>

            <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal"
                data-bs-target="#deleteModal">
                حذف <i class="fa fa-trash ms-1"></i>
            </button>
            <div class="vr"></div>

            <div class="dropdown">
                <button class="btn btn-outline-dark btn-sm" type="button" id="printDropdown" data-bs-toggle="dropdown">
                    طباعة <i class="fa fa-print ms-1"></i>
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#"><i class="fa fa-file-pdf me-2 text-danger"></i>PDF
                            طباعة</a></li>
                    <li><a class="dropdown-item" href="#"><i class="fa fa-file-excel me-2 text-success"></i>Excel
                            تصدير</a></li>
                </ul>
            </div>
        </div>

        <div class="card-body">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#details" role="tab">التفاصيل</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#products" role="tab">المنتجات</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#activity" role="tab">سجل النشاطات</a>
                </li>
            </ul>

            <div class="tab-content p-3">
                <!-- تبويب التفاصيل -->
                <div class="tab-pane active" id="details" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td class="text-start" style="width: 50%">
                                        <div class="mb-2">
                                            <label class="text-muted">رقم الطلب:</label>
                                            <div>{{ $purchaseOrder->code }}</div>
                                        </div>
                                        <div class="mb-2">
                                            <label class="text-muted">العنوان:</label>
                                            <div>{{ $purchaseOrder->title }}</div>
                                        </div>
                                        <div class="mb-2">
                                            <label class="text-muted">تاريخ الطلب:</label>
                                            <div>{{ $purchaseOrder->order_date }}</div>
                                        </div>
                                        <div class="mb-2">
                                            <label class="text-muted">منشئ الطلب:</label>
                                            <div>{{ $purchaseOrder->creator->name ?? 'غير محدد' }}</div>
                                        </div>
                                    </td>
                                    <td class="text-start" style="width: 50%">
                                        <div class="mb-2">
                                            <label class="text-muted">تاريخ الاستحقاق:</label>
                                            <div>{{ $purchaseOrder->due_date ?? 'غير محدد' }}</div>
                                        </div>
                                        <div class="mb-2">
                                            <label class="text-muted">عدد المنتجات:</label>
                                            <div>{{ $purchaseOrder->productDetails->count() }}</div>
                                        </div>
                                        <div class="mb-2">
                                            <label class="text-muted">الملاحظات:</label>
                                            <div>{{ $purchaseOrder->notes ?? 'لا توجد ملاحظات' }}</div>
                                        </div>
                                        <div class="mb-2">
                                            <label class="text-muted">المرفقات:</label>
                                            @if ($purchaseOrder->attachments)
                                                <div><a href="{{ asset('assets/uploads/purchase_orders/' . $purchaseOrder->attachments) }}"
                                                        target="_blank">عرض المرفق</a></div>
                                            @else
                                                <div>لا توجد مرفقات</div>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div style="background-color: #f8f9fa;"
                        class="d-flex justify-content-between align-items-center p-2 rounded mb-3">
                        <h5 class="mb-0"> المنتجات </h5>
                    </div>
                    <div class="table-responsive mb-4">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>منتج</th>
                                    <th>الكمية</th>
                                    <th class="text-end">معامل التحويل </th>
                                    <th class="text-end">Unit Factor </th>

                                    <th class="text-end">اسم الوحدة  الاكبر  </th>
                                    <th class="text-end">Unit Name Small  </th>                                </tr>
                            </thead>
                            @foreach ($productDetails as $detail)
                                <tbody>
                                    <tr>

                                        <td>{{ $detail->product->name ?? '--' }}</td>
                                        <td>{{ $detail->quantity }}</td>
                                        <td class="text-end">{{ $detail->conversion_factor??'--' }}</td>
                                        <td>{{ $detail->unit->name ?? '--' }}</td>
                                        <td class="text-end">{{ $detail->unit->name_small ?? '--' }}</td>
                                    </tr>

                                </tbody>
                            @endforeach
                        </table>
                    </div>



                    </div>
                </div>

                <!-- تبويب المنتجات -->
                <div class="tab-pane" id="products" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>المنتج</th>
                                    <th>الكمية</th>
                                    <th>تاريخ الإضافة</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($purchaseOrder->productDetails as $detail)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $detail->product->name }}</td>
                                        <td>{{ $detail->quantity }}</td>
                                        <td>{{ $detail->created_at->format('Y-m-d') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- تبويب سجل النشاطات -->
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
                    <h5 class="modal-title">حذف طلب الشراء</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>هل أنت متأكد من حذف طلب الشراء رقم "{{ $purchaseOrder->code }}"؟</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">إلغاء</button>
                    <form action="{{ route('OrdersPurchases.destroy', $purchaseOrder->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">حذف</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
