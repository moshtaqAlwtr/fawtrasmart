@extends('master')

@section('title')
قيمة المخزون التقديرية
@stop

@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">قيمة المخزون التقديرية</h2>
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
                    <table class="table">
                        <thead class="table-light">
                            <tr>
                                <th>الكود</th>
                                <th>الاسم</th>
                                <th>الكمية</th>
                                <th>سعر البيع الحالي</th>
                                <th>متوسط سعر الشراء</th>
                                <th>إجمالي سعر البيع المتوقع</th>
                                <th>إجمالي سعر الشراء</th>
                                <th>الربح المتوقع</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                @php
                                    $totalPurchasePrice = $product->product->purchase_price * $product->quantity;
                                    $totalSalePrice = $product->product->sale_price * $product->quantity;
                                    $expectedProfit = $totalSalePrice - $totalPurchasePrice;
                                @endphp
                                <tr>
                                    <td>{{ $product->product->barcode }}</td>
                                    <td>{{ $product->product->name }}</td>
                                    <td>{{ $product->quantity }}</td>
                                    <td>{{ number_format($product->product->sale_price, 2) }}</td>
                                    <td>{{ number_format($product->product->purchase_price, 2) }}</td>
                                    <td>{{ number_format($totalSalePrice, 2) }}</td>
                                    <td>{{ number_format($totalPurchasePrice, 2) }}</td>
                                    <td>{{ number_format($expectedProfit, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="table-info">
                                <td colspan="5"><strong>الإجمالي</strong></td>
                                <td><strong>{{ number_format($products->sum(fn($p) => $p->product->sale_price * $p->quantity), 2) }}</strong></td>
                                <td><strong>{{ number_format($products->sum(fn($p) => $p->product->purchase_price * $p->quantity), 2) }}</strong></td>
                                <td><strong>{{ number_format($products->sum(fn($p) => ($p->product->sale_price * $p->quantity) - ($p->product->purchase_price * $p->quantity)), 2) }}</strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

    </div>

@endsection


@section('scripts')
@endsection
a
