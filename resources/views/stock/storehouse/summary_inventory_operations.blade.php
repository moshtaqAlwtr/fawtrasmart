@extends('master')

@section('title')
ملخص عمليات المخزون
@stop

@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">ملخص عمليات المخزون</h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="">الرئيسيه</a>
                            </li>
                            <li class="breadcrumb-item active">{{ $storehouse->name }}
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="content-body">

        @include('layouts.alerts.error')
        @include('layouts.alerts.success')

        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div></div>
                    <div>
                        <a href="#" class="btn btn-outline-info mb-1"><i class="fa fa-print"></i> طباعة</a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead class="table-light">
                            <tr>
                                <th rowspan="2" class="border border-info">اسم المنتج</th>
                                <th colspan="5" class="border border-info">الوارد</th>
                                <th colspan="5" class="border border-info">المنصرف</th>
                                <th rowspan="2" class="border border-info">إجمالي الحركة</th>
                            </tr>
                            <tr class="table-info">
                                <th>فواتير الشراء</th>
                                <th>الفواتير المرتجعة</th>
                                <th>التحويل</th>
                                <th>يدوي</th>
                                <th>الإجمالي</th>
                                <th>فواتير البيع</th>
                                <th>مرتجع مشتريات</th>
                                <th>التحويل</th>
                                <th>يدوي</th>
                                <th>الإجمالي</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td><strong><a href="{{ route('products.show', $product['id']) }}">{{ $product['name'] }}</a></strong></td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>{{ $product['incoming_transfer'] }}</td>
                                    <td>{{ $product['incoming_manual'] }}</td>
                                    <td>{{ $product['incoming_total'] }}</td>

                                    <td>0</td>
                                    <td>0</td>
                                    <td>{{ $product['outgoing_transfer'] != 0 ? '-' . $product['outgoing_transfer'] : 0 }}</td>
                                    <td>{{ $product['outgoing_manual'] != 0 ? '-' . $product['outgoing_manual'] : 0 }}</td>
                                    <td>{{ $product['outgoing_total'] != 0 ? '-' . $product['outgoing_total'] : 0 }}</td>

                                    <td class="active">
                                        <a href=""><u><strong>{{ $product['movement_total'] }}</strong></u></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>

    </div>

@endsection


@section('scripts')
@endsection
a
