@extends('master')

@section('title')
سجل اشعارات النظام 
@stop

@section('content')

<style>
    .timeline-date {
        text-align: center;
        font-size: 18px;
        font-weight: bold;
        margin: 20px 0;
        color: #333;
    }

    .timeline-day-circle {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background-color: #007bff; /* لون الخلفية */
        color: #fff; /* لون النص */
        font-weight: bold;
        font-size: 16px;
        margin: 10px auto;
        text-align: center;
        position: relative;
    }

    .timeline-day-circle::after {
        content: '';
        position: absolute;
        width: 100%;
        height: 2px;
        background-color: #007bff; /* لون الخط */
        top: 50%;
        left: 100%;
        transform: translateY(-50%);
    }

    .timeline-event {
        display: flex;
        align-items: center;
        margin-left: 60px;
        margin-bottom: 20px;
        position: relative;
    }

    .timeline-event::before {
        content: '';
        position: absolute;
        width: 2px;
        height: 100%;
        background-color: #007bff; /* لون الخط */
        top: 0;
        left: -20px;
    }

    .timeline-event-circle {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: #28a745; /* لون الخلفية */
        color: #fff; /* لون النص */
        font-weight: bold;
        font-size: 14px;
        margin-right: 10px;
        flex-shrink: 0;
    }

    .timeline-info {
        flex-grow: 1;
    }

    .timeline-info p {
        margin: 0;
    }

    .timeline-info span {
        font-size: 14px;
        color: #666;
    }
</style>

<div class="content-body">
    <div class="container" style="max-width: 1200px">
        <div class="card">
            <div class="card-body">
                <!-- حقل البحث -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <form action="{{ route('logs.index') }}" method="GET">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control" placeholder="ابحث في الأحداث..." value="{{ $search ?? '' }}">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit">بحث</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- الجدول الزمني -->
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            @if(isset($logs) && $logs->count() > 0)
                                <ul class="activity-timeline timeline-left list-unstyled">
                                    @php
                                        $previousDate = null; // لتخزين التاريخ السابق
                                    @endphp
                                    @foreach($logs as $date => $dayLogs)
                                        @php
                                            $currentDate = \Carbon\Carbon::parse($date);
                                            $diffInDays = $previousDate ? $previousDate->diffInDays($currentDate) : 0;
                                        @endphp

                                        @if($diffInDays > 7) <!-- إذا كان الفارق أكثر من أسبوع -->
                                            <li class="timeline-date">
                                                <h4>{{ $currentDate->format('Y-m-d') }}</h4>
                                            </li>
                                        @endif

                                        <!-- دائرة اليوم -->
                                        <li class="timeline-day">
                                            <div class="timeline-day-circle">
                                                {{ $currentDate->translatedFormat('l') }} <!-- اليوم (مثل الأربعاء) -->
                                            </div>
                                        </li>

                                        @foreach($dayLogs as $log)
                                            @if ($log)
                                                <!-- حدث -->
                                                <li class="timeline-event">
                                                    <div class="timeline-event-circle">
                                                        <i class="feather icon-package font-medium-2"></i>
                                                    </div>
                                                    <div class="timeline-info">
                                                        <p>{!! Str::markdown($log->description ?? 'لا يوجد وصف') !!}</p>
                                                        <br>
                                                        <span>
                                                            <span class="tip observed tooltipstered" data-title="">
                                                                <i class="fa fa-user"></i> {{ $log->user->name ?? 'مستخدم غير معروف' }}
                                                            </span> - 
                                                            <i class="fa fa-building"> {{ $log->user->branch->name ?? 'فرع غير معروف' }}</i>
                                                        </span>
                                                    </div>
                                                </li>
                                            @endif
                                        @endforeach

                                        @php
                                            $previousDate = $currentDate; // تحديث التاريخ السابق
                                        @endphp
                                    @endforeach
                                </ul>
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
    </div>
</div>
@endsection