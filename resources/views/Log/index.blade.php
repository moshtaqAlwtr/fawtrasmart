@extends('master')

@section('title')
سجل النشاطات
@stop

@section('css')
<link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
        content: "\f111";
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
        font-size: 16px;
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
    .search-form {
        display: flex;
        align-items: center;
        width: 100%;
    }
    .search-form .form-control {
        border-radius: 8px;
        box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
    }
    .no-activities {
        text-align: center;
        padding: 30px;
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }
    .markdown-content {
        margin-bottom: 10px;
    }
    .view-options {
        margin-left: 15px;
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
                        <li class="breadcrumb-item"><a href="">الرئيسية</a></li>
                        <li class="breadcrumb-item active">عرض</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="container">
            <div class="row mt-4">
                <div class="col-12">
                    <!-- شريط التصفية والبحث -->
                    <div class="filter-bar">
                        <form action="{{ route('logs.index') }}" method="GET" class="search-form">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control" placeholder="ابحث في الأحداث..." value="{{ $search ?? '' }}">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="fas fa-search"></i> بحث
                                    </button>
                                </div>
                            </div>
                            
                            <div class="view-options">
                               
                            </div>
                        </form>
                    </div>

                    <!-- الجدول الزمني -->
                    @if(isset($logs) && $logs->count() > 0)
                        @php $previousDate = null; @endphp
                        @foreach($logs as $date => $dayLogs)
                            @php
                                $currentDate = \Carbon\Carbon::parse($date);
                                $diffInDays = $previousDate ? $previousDate->diffInDays($currentDate) : 0;
                            @endphp

                            @if($diffInDays > 7)
                                <div class="timeline-day">
                                    {{ $currentDate->format('Y-m-d') }}
                                </div>
                            @endif

                            <div class="timeline-day">
                                {{ $currentDate->translatedFormat('l') }}
                            </div>

                            <ul class="timeline">
                                @foreach($dayLogs as $log)
                                    @if ($log)
                                        <li class="timeline-item">
                                            <div class="timeline-content">
                                                <div class="time">
                                                    <i class="far fa-clock"></i> {{ $log->created_at->format('H:i:s') }}
                                                </div>
                                                <div class="markdown-content">
                                                    {!! Str::markdown($log->description ?? 'لا يوجد وصف') !!}
                                                </div>
                                                <div class="text-muted">
                                                    <i class="fas fa-user"></i> {{ $log->user->name ?? 'مستخدم غير معروف' }} - 
                                                    <i class="fas fa-building"></i> {{ $log->user->branch->name ?? 'فرع غير معروف' }}
                                                </div>
                                            </div>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>

                            @php $previousDate = $currentDate; @endphp
                        @endforeach
                    @else
                        <div class="no-activities">
                            <i class="fas fa-info-circle fa-3x mb-3" style="color: #6c757d;"></i>
                            <p class="mb-0">لا توجد نشاطات مسجلة حتى الآن!</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
@endsection