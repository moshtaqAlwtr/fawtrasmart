@extends('master')

@section('title')
    عرض المورد
@stop

@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">عرض المورد</h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="">الرئيسيه</a></li>

                            <li class="breadcrumb-item active">عرض</li>

                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <a href="{{ route('SupplierManagement.edit', $supplier->id) }}" class="btn btn-success">
                    <i class="fa fa-edit me-1"></i>
                    تعديل المورد
                </a>

                <div class="text-end">
                    <h5 class="text-muted mb-0">{{$supplier->trade_name}} # {{ $supplier->id}}</h5>
                    <small class="text-muted">حساب الأستاذ: شركة دار يريف المحدودة #222118</small>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-title p-2 d-flex align-items-center gap-2">

            <a href="{{ route('SupplierManagement.edit', $supplier->id) }}"
                class="btn btn-outline-primary btn-sm d-inline-flex align-items-center justify-content-center px-3"
                style="min-width: 90px;">
                تعديل البيانات <i class="fa fa-edit ms-1"></i>


                <a href="#"
                class="btn btn-outline-success btn-sm d-inline-flex align-items-center justify-content-center px-3"
                style="min-width: 90px;">
                إضافة رصيد افتتاحي <i class="fa fa-plus-circle ms-1"></i>
            </a>
            <div class="vr"></div>

            <a href="#"
                class="btn btn-outline-info btn-sm d-inline-flex align-items-center justify-content-center px-3"
                style="min-width: 90px;">
                كشف حساب <i class="fa fa-file-text ms-1"></i>
            </a>
            <div class="vr"></div>

            <a href="#"
                class="btn btn-outline-dark btn-sm d-inline-flex align-items-center justify-content-center px-3"
                style="min-width: 90px;">
                إنشاء فاتورة شراء <i class="fa fa-shopping-cart ms-1"></i>
            </a>
            <div class="vr"></div>
            </a>

            <a href="#"
                class="btn btn-outline-primary btn-sm d-inline-flex align-items-center justify-content-center px-3"
                style="min-width: 90px;">
                أضف رصيد مدفوعات <i class="fa fa-money ms-1"></i>
            </a>
            <div class="vr"></div>

            <a href="#"
                class="btn btn-outline-secondary btn-sm d-inline-flex align-items-center justify-content-center px-3"
                style="min-width: 90px;">
                موقوف <i class="fa fa-ban ms-1"></i>
            </a>
            <div class="vr"></div>

            <a href="#"
                class="btn btn-outline-danger btn-sm d-inline-flex align-items-center justify-content-center px-3"
                style="min-width: 90px;" data-bs-toggle="modal" data-bs-target="#modal_DELETE1">
                حذف <i class="fa fa-trash ms-1"></i>
            </a>


        </div>

        <!-- Modal Delete -->
        <div class="modal fade" id="modal_DELETE1" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title">حذف المورد</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p>هل أنت متأكد من حذف هذا المورد؟</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">إلغاء</button>
                        <form action="{{ route('SupplierManagement.destroy', $supplier->id) }}" method="POST"
                            class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">حذف</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#details" role="tab">
                        <span>التفاصيل</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#activity" role="tab">
                        <span>سجل النشاطات</span>
                    </a>
                </li>
            </ul>

            <div class="tab-content p-3">
                <!-- تبويب التفاصيل -->
                <div class="tab-pane active" id="details" role="tabpanel">

                </div>

                <!-- تبويب سجل النشاطات -->
                <div class="tab-pane" id="activity" role="tabpanel">
                    <div class="timeline p-4">
                        <!-- يمكن إضافة سجل النشاطات هنا -->
                        <p class="text-muted text-center">لا توجد نشاطات حتى الآن</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
