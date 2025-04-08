@extends('master')

@section('title')
    تحليل الزيارات
@stop

@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">تحليل الزيارات</h2>
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

    @foreach ($groups as $group)
        <h4 class="mt-4">📍 {{ $group->name }}</h4>

        @php
            // جمع جميع العملاء من جميع أحياء هذه المجموعة
            $clients = $group->neighborhoods->flatMap(function($neighborhood) {
                return $neighborhood->clients;
            })->unique('id');
        @endphp

        @if($clients->count() > 0)
            <ul class="list-group mb-4">
                @foreach ($clients as $client)
                    <li class="list-group-item">{{ $client->name }}</li>
                @endforeach
            </ul>
        @else
            <div class="alert alert-info">لا يوجد عملاء في هذه المجموعة</div>
        @endif
    @endforeach
@endsection
