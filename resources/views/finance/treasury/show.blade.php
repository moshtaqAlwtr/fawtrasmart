@extends('master')

@section('title')
خزائن وحسابات بنكية
@stop

@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-left mb-0">خزائن وحسابات بنكية</h2>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="">الرئيسية</a></li>
                        <li class="breadcrumb-item active">عرض</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-title p-2">
        <a href="{{ route('treasury.transferin') }}" class="btn btn-outline-success btn-sm">
            تحويل <i class="fa fa-reply-all"></i>
        </a>
    </div>

    <div class="content-body">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <div>
                        <strong>
                            @if($treasury->type_accont == 0)
                                <i class="fa fa-archive"></i>
                            @else
                                <i class="fa fa-bank"></i>
                            @endif
                            {{ $treasury->name }}
                        </strong>
                    </div>

                    <div>
                        @if ($treasury->is_active == 0)
                            <div class="badge badge-pill badge-success">نشط</div>
                        @else
                            <div class="badge badge-pill badge-danger">غير نشط</div>
                        @endif
                    </div>

                    <div>
                        <small>SAR </small> <strong>{{ number_format($treasury->balance, 2) }}</strong>
                    </div>
                </div>
            </div>
        </div>

        @include('layouts.alerts.error')
        @include('layouts.alerts.success')

        <div class="card">
            <div class="card-body">
                <!-- 🔹 التبويبات -->
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab">التفاصيل</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="activate-tab" data-toggle="tab" href="#activate" role="tab">سجل النشاطات</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="transactions-tab" data-toggle="tab" href="#transactions" role="tab">معاملات النظام</a>
                    </li>
                </ul>

                <div class="tab-content">
                    <!-- 🔹 تبويب التفاصيل -->
                    <div class="tab-pane fade show active" id="home" role="tabpanel">
                        <div class="card">
                            <div class="card-header"><strong>معلومات الحساب</strong></div>
                            <div class="card-body">
                                <table class="table">
                                    <tr>
                                        <td><small>الاسم</small> : <strong>{{ $treasury->name }}</strong></td>
                                        @if($treasury->type_accont == 1)
                                            <td><small>اسم الحساب البنكي</small> : <strong>{{ $treasury->name }}</strong></td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <td><small>النوع</small> : <strong>@if($treasury->type_accont == 0) خزينة @else حساب بنكي @endif</strong></td>
                                        <td><small>الحالة</small> : 
                                            @if ($treasury->is_active == 0)
                                                <div class="badge badge-pill badge-success">نشط</div>
                                            @else
                                                <div class="badge badge-pill badge-danger">غير نشط</div>
                                            @endif
                                        </td>
                                        <td><small>المبلغ</small> : <strong style="color: #00CFE8">{{ number_format($treasury->balance, 2) }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td><strong>الوصف</strong> : <small>{{ $treasury->description ?? "" }}</small></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- 🔹 تبويب سجل النشاطات -->
                    <div class="tab-pane fade" id="activate" role="tabpanel">
                        <p>سجل النشاطات هنا...</p>
                    </div>

                    <!-- 🔹 تبويب معاملات النظام -->
                    <div class="tab-pane fade" id="transactions" role="tabpanel">
                        <div class="card">
                            <div class="card-header">
                             
                                <form>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>التاريخ من</label>
                                                <input type="date" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>التاريخ إلى</label>
                                                <input type="date" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>البحث بواسطة الحالة</label>
                                                <select class="form-control">
                                                    <option>اختر الحالة</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>البحث بواسطة الفرع</label>
                                                <select class="form-control">
                                                    <option>اختر الفرع</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>البحث بواسطة النوع</label>
                                                <select class="form-control">
                                                    <option>اختر النوع</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>المبلغ من</label>
                                                <input type="number" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>المبلغ إلى</label>
                                                <input type="number" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer text-center">
                                        <button type="submit" class="btn btn-primary">بحث</button>
                                        <button type="reset" class="btn btn-secondary">إعادة تعيين</button>
                                    </div>
                                </form>
                                
                            </div>
                    
                            <div class="card-body">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>العملية</th>
                                            <th>الإيداع</th>
                                            <th>السحب</th>
                                            <th>الرصيد بعد</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- @foreach($transactions as $transaction)
                                        <tr>
                                            <td>
                                                <strong>#{{ $transaction->id }}</strong> 
                                                {{ \Carbon\Carbon::parse($transaction->date)->format('d/m/Y') }}
                                                <br>
                                                {{ $transaction->description }}
                                            </td>
                                            <td style="color: green;">{{ number_format($transaction->deposit, 2) }}</td>
                                            <td style="color: red;">{{ number_format($transaction->withdraw, 2) }}</td>
                                            <td><strong>{{ number_format($transaction->balance_after, 2) }}</strong></td>
                                        </tr>
                                        @endforeach --}}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div> <!-- tab-content -->
            </div> <!-- card-body -->
        </div> <!-- card -->
    </div> <!-- content-body -->
</div> <!-- card -->

@endsection
