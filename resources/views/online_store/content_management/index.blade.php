@extends('master')

@section('title')
إعدادات واجهة التسوق
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
                                <a href="{{ route('content_management.media') }}">
                                    <img class="p-3" src="{{ asset('app-assets/images/gallery.png') }}" alt="img placeholder">
                                    <h5><strong>إدارة معرض الصور</strong></h5>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-sm-6 col-12">
                    <div class="card hover-card">
                        <div class="card-content">
                            <div class="card-body setting">
                                <a href="{{ route('content_management.page_management') }}">
                                    <img class="p-3" src="{{ asset('app-assets/images/dynamic.png') }}" alt="img placeholder">
                                    <h5><strong>إدارة صفحات المحتوى</strong></h5>
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
                                    <img class="p-3" src="{{ asset('app-assets/images/paper.png') }}" alt="img placeholder">
                                    <h5><strong>إدارة عناصر القائمة</strong></h5>
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
