
@extends('master')

@section('title')
    تحليل الزيارات
@stop

@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">تحليل الزيارات   </h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="">الرئيسيه</a></li>
                            <li class="breadcrumb-item active">عرض </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @foreach ($groups as $group)
    <h4>{{ $group->name }}</h4>
    <table>
        <thead>
            <tr>
                <th>العميل</th>
                @foreach ($weeks as $week)
                    <th>
                        {{ \Carbon\Carbon::parse($week['start'])->format('d M') }} -
                        {{ \Carbon\Carbon::parse($week['end'])->format('d M') }}
                    </th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($group->clients as $client)
                <tr>
                    <td>{{ $client->name }}</td>
                    @foreach ($weeks as $week)
                        @php
                            $hasInvoice = \App\Models\Invoice::where('client_id', $client->id)
                                ->whereBetween('created_at', [$week['start'], $week['end']])
                                ->exists();

                            $hasPayment = \App\Models\Payment::where('client_id', $client->id)
                                ->whereBetween('created_at', [$week['start'], $week['end']])
                                ->exists();

                            $hasNote = \App\Models\Note::where('client_id', $client->id)
                                ->whereBetween('created_at', [$week['start'], $week['end']])
                                ->exists();

                            $hasVisit = \App\Models\Visit::where('client_id', $client->id)
                                ->whereBetween('created_at', [$week['start'], $week['end']])
                                ->exists();
                        @endphp
                        <td>
                            @if ($hasInvoice)
                                🧾
                            @endif
                            @if ($hasPayment)
                                💵
                            @endif
                            @if ($hasNote)
                                📝
                            @endif
                            @if ($hasVisit)
                                👣
                            @endif
                            @if (!($hasInvoice || $hasPayment || $hasNote || $hasVisit))
                                ❌
                            @endif
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
@endforeach



@endsection
