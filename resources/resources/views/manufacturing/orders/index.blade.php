@extends('master')

@section('title')
أوامر التصنيع
@stop

@section('content')

    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">أوامر التصنيع</h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="">الرئيسيه</a>
                            </li>
                            <li class="breadcrumb-item active">عرض
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="content-body">

        <!-- بطاقة البحث -->
        <div class="card">
            <div class="card-content">
                <div class="card-body">
                    <div class="card-title">
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <div></div>
                            <div>
                                <a href="{{ route('manufacturing.orders.create') }}" class="btn btn-outline-success">
                                    <i class="fa fa-plus me-2"></i>أضف أمر تصنيع
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('layouts.alerts.error')
        @include('layouts.alerts.success')

        <!-- كرت البحث -->
        <div class="card mt-3">
            <div class="card-body">
                <h4 class="card-title">بحث وتصنيف</h4>
                <div class="row mb-3">
                    <!-- السطر الأول من الحقول -->
                    <div class="col-md-4">
                        <input type="text" class="form-control" placeholder="البحث بواسطة الاسم أو الكود">
                    </div>
                    <div class="col-md-4">
                        <select class="form-control" aria-label="فرز بواسطة المنتج">
                            <option selected>فرز بواسطة المنتج</option>
                            <option value="1">منتج 1</option>
                            <option value="2">منتج 2</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <select class="form-control" aria-label="فرز بواسطة قائمة المواد">
                            <option selected>فرز بواسطة قائمة المواد</option>
                            <option value="1">قائمة 1</option>
                            <option value="2">قائمة 2</option>
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <!-- السطر الثاني من الحقول -->
                    <div class="col-md-4">
                        <select class="form-control" aria-label="إختر الحالة">
                            <option selected>إختر الحالة</option>
                            <option value="1">نشط</option>
                            <option value="2">قيد التنفيذ</option>
                            <option value="3">منتهي</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <select class="form-control" aria-label="إختر العميل">
                            <option selected>إختر عميل</option>
                            <option value="1">عميل 1</option>
                            <option value="2">عميل 2</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <select class="form-control" aria-label="إختر المرحلة الإنتاجية">
                            <option selected>إختر المرحلة الإنتاجية</option>
                            <option value="1">مرحلة 1</option>
                            <option value="2">مرحلة 2</option>
                            <option value="3">مرحلة 3</option>
                        </select>
                    </div>
                </div>

                <!-- الأزرار في سطر مستقل -->
                <div class="row mt-3">
                    <div class="col-12 text-right">
                        <button class="btn btn-primary me-2">بحث</button>
                        <button class="btn btn-secondary">إعادة تعيين</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- كرت الجدول -->
        <div class="card mt-4">
            <div class="card-body">
                @if(isset($orders) && count($orders) > 0)
                    <table class="table table-striped">
                        <thead class="thead-light">
                            <tr>
                                <th>الاسم</th>
                                <th>المنتج الرئيسي</th>
                                <th>الكمية</th>
                                <th>التاريخ</th>
                                <th>التكلفة الإجمالية</th>
                                <th>العميل</th>
                                <th>الحالة</th>
                                <th>ترتيب</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <td>
                                        <strong>{{ $order->name }}</strong><br>
                                        <small class="text-muted">{{ $order->code }}</small>
                                    </td>
                                    <td>{{ $order->product->name }}</td>
                                    <td><strong>{{ $order->quantity }}</strong></td>
                                    <td>
                                        <div>يبدأ : <strong>{{ $order->from_date }}</strong></div>
                                        <div>ينتهي : <strong>{{ $order->to_date }}</strong></div>
                                    </td>
                                    <td><strong>{{ number_format($order->last_total_cost) }} ر.س</strong></td>
                                    <td>
                                        <strong>{{ $order->client->trade_name }}</strong><br>
                                        <small class="text-muted">#{{ $order->client->code }}</small>
                                    </td>
                                    <td><span class="badge badge-primary">قيد التنفيذ</span></td>
                                    <td>
                                        <div class="btn-group">
                                            <div class="dropdown">
                                                <button class="btn bg-gradient-info fa fa-ellipsis-v mr-1 btn-sm" type="button" id="dropdownMenuButton303" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton303">
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('manufacturing.orders.show', $order->id) }}">
                                                            <i class="fa fa-eye me-2 text-primary"></i>عرض
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('manufacturing.orders.edit', $order->id) }}">
                                                            <i class="fa fa-edit me-2 text-success"></i>تعديل
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item text-danger" href="#" data-toggle="modal" data-target="#modal_DELETE{{ $order->id }}">
                                                            <i class="fa fa-trash me-2"></i>حذف
                                                        </a>
                                                    </li>
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Modal delete -->
                                    <div class="modal fade text-left" id="modal_DELETE{{ $order->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-scrollable" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header" style="background-color: #EA5455 !important;">
                                                    <h4 class="modal-title" id="myModalLabel1" style="color: #FFFFFF">حذف {{ $order->name }}</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true" style="color: #DC3545">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <strong>
                                                        هل انت متاكد من انك تريد الحذف ؟
                                                    </strong>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light waves-effect waves-light" data-dismiss="modal">الغاء</button>
                                                    <a href="{{ route('manufacturing.orders.delete', $order->id) }}" class="btn btn-danger waves-effect waves-light">تأكيد</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end delete-->

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="alert alert-danger text-xl-center" role="alert">
                        <p class="mb-0">
                            لا توجد اوامر تصنيع مضافة حتى الان !!
                        </p>
                    </div>
                @endif
            </div>
        </div>

    </div>

@endsection
