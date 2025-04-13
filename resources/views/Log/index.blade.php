@extends('master')

@section('title')
 سجل النشاطات
@stop

@section('css')
<link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
<style>
    .timeline {
        position: relative;
        margin: 20px 0;
        padding: 0;
        list-style: none;
    }
    .timeline::before {
        content: '';
        position: absolute;
        top: 50px;
        bottom: 0;
        width: 4px;
        background: linear-gradient(180deg, #28a745 0%, #218838 100%);
        right: 50px;
        margin-right: -2px;
    }
    .timeline-item {
        margin: 0 0 20px;
        padding-right: 100px;
        position: relative;
        text-align: right;
    }
    .timeline-item::before {
        content: "\f067";
        font-family: 'Font Awesome 5 Free';
        font-weight: 900;
        position: absolute;
        right: 30px;
        top: 15px;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(145deg, #28a745, #218838);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        color: #ffffff;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    }
    .timeline-content {
        background: #ffffff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        position: relative;
    }
    .timeline-content .time {
        font-size: 14px;
        color: #6c757d;
        margin-bottom: 10px;
    }

    .filter-bar {
        background-color: #ffffff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        margin-bottom: 30px;
    }
    .timeline-day {
        background-color: #ffffff;
        padding: 10px 20px;
        border-radius: 30px;
        text-align: center;
        margin-bottom: 20px;
        font-weight: bold;
        color: #333;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        display: inline-block;
        position: relative;
        top: 0;
        right: 50px;
        transform: translateX(50%);
    }
    .filter-bar .form-control {
        border-radius: 8px;
        box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
    }
    .filter-bar .btn-outline-secondary {
        border-radius: 8px;
        box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
    }
    .timeline-date {
        text-align: center;
        font-size: 18px;
        font-weight: bold;
        margin: 20px 0;
        color: #333;
    }
</style>
@endsection

@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-left mb-0">سجل النشاطات</h2>
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
    <div class="card">
        <div class="container">
            <div class="row mt-4">
                <div class="col-12">
                    <!-- شريط التصفية -->
                    <div class="filter-bar d-flex justify-content-between align-items-center">
                        <div>
                            <button class="btn btn-outline-secondary"><i class="fas fa-th"></i></button>
                            <button class="btn btn-outline-secondary"><i class="fas fa-list"></i></button>
                        </div>
                        <div class="d-flex">
                            <form action="{{ route('logs.index') }}" method="GET" class="d-flex">
                                <input type="text" name="search" class="form-control me-2" placeholder="ابحث في الأحداث..." value="{{ $search ?? '' }}">
                                <button class="btn btn-primary" type="submit">بحث</button>
                            </form>
                        </div>
                    </div>

                    <!-- الجدول الزمني -->
                    @if(isset($logs) && $logs->count() > 0)
                        @php
                            $previousDate = null;
                        @endphp

                        @foreach($logs as $date => $dayLogs)
                            @php
                                $currentDate = \Carbon\Carbon::parse($date);
                                $diffInDays = $previousDate ? $previousDate->diffInDays($currentDate) : 0;
                            @endphp

                            @if($diffInDays > 7)
                                <div class="timeline-date">
                                    <h4>{{ $currentDate->format('Y-m-d') }}</h4>
                                </div>
                            @endif

                            <div class="timeline-day">{{ $currentDate->translatedFormat('l') }}</div>

                            <ul class="timeline">
                                @foreach($dayLogs as $log)
                                    @if ($log)
                                        <li class="timeline-item">
                                            <div class="timeline-content">
                                                <div class="time">
                                                    <i class="far fa-clock"></i> {{ $log->created_at->format('H:i:s') }}
                                                </div>
                                                <div>
                                                    <strong>{{ $log->user->name ?? 'مستخدم غير معروف' }}</strong>
                                                    {!! Str::markdown($log->description ?? 'لا يوجد وصف') !!}
                                                    <div class="text-muted">{{ $log->user->branch->name ?? 'فرع غير معروف' }}</div>
                                                </div>
                                            </div>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>

                            @php
                                $previousDate = $currentDate;
                            @endphp
                        @endforeach
                    @else
                        <div class="alert alert-danger text-xl-center" role="alert">
                            <p class="mb-0">لا توجد عمليات مضافه حتى الان !!</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@endsection
