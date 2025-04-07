@extends('master')

@section('title')
اعدادات العميل
@stop

@section('css')
    <style>
        .setting{
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            flex-direction: column;
        }
        .hover-card:hover{
            background-color: #cdd2d8;
            scale: .98;
        }
        .container{
            max-width: 1200px;
        }
    </style>
@endsection

@section('content')
    <div class="content-body">

        <section id="statistics-card" class="container">
            <div class="row">

                <div class="col-lg-4 col-sm-6 col-12">
                    <div class="card hover-card">
                        <div class="card-content">
                            <div class="card-body setting">
                                <a href="{{ route('clients.general') }}">
                                    <img class="p-3" src="{{ asset('app-assets/images/icons8-user-90.png') }}" alt="img placeholder">

                                    <h5><strong>عام</strong></h5>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-sm-6 col-12">
                    <div class="card hover-card">
                        <div class="card-content">
                            <div class="card-body setting">
                                <a href="{{ route('clients.permission') }}">
                                    <img class="p-3" src="{{ asset('app-assets/images/icons8-user-lock-100.png') }}" alt="img placeholder">
                                    <h5><strong>صلاحيات العميل</strong></h5>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-sm-6 col-12">
                    <div class="card hover-card">
                        <div class="card-content">
                            <div class="card-body setting">
                                <a href="{{ route('SupplyOrders.edit_status') }}">
                                    <img class="p-3" src="{{ asset('app-assets/images/icons8-pager-100.png') }}" alt="img placeholder">
                                    <h5><strong>حالات متابعة العميل</strong></h5>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-sm-6 col-12">
                    <div class="card hover-card">
                        <div class="card-content">
                            <div class="card-body setting">
                                <a href="">
                                    <img class="p-3" src="{{ asset('app-assets/images/icons8-pager-100.png') }}" alt="img placeholder">
                                    <h5><strong>الحقول الاضافية الخاصة بالعميل</strong></h5>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 col-12">
                    <div class="card hover-card">
                        <div class="card-content">
                            <div class="card-body setting">
                                <a href="">
                                    <img class="p-3" src="{{ asset('app-assets/images/icons8-pager-100.png') }}" alt="img placeholder">
                                    <h5><strong>اعدادات المجموعات</strong></h5>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 col-12">
                    <div class="card hover-card">
                        <div class="card-content">
                            <div class="card-body setting">
                                <a href="{{ route('visits.traffics') }}">
                                    <img class="p-3" src="{{ asset('app-assets/images/icons8-pager-100.png') }}" alt="img placeholder">
                                    <h5><strong>تحليل الزيارات </strong></h5>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </section>

    </div>

@endsection


@section('scripts')
@endsection



