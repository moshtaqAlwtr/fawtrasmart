@extends('master')

@section('title')
    الأستاذ العام
@stop

@section('css')
    <style>
        .report-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .report-header h2 {
            font-weight: bold;
            color: #2c3e50;
        }

        .form-card {
            background: #f9f9f9;
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .form-filter {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .form-filter div {
            flex: 1 1 200px;
        }

        .form-filter label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .btn-container {
            align-self: end;
        }

        .data-card {
            background: #ffffff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .table thead th {
            background-color: #eee;
            font-weight: bold;
        }

        .totals-row td {
            font-weight: bold;
            background-color: #f1f1f1;
        }
          .form-card {
        background-color: #f8f9fa;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        padding: 20px;
        margin-bottom: 20px;
    }

    .form-filter {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        align-items: flex-end;
    }

    .form-filter div {
        flex: 1;
        min-width: 200px;
    }

    .form-filter label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
        color: #333;
    }

    .form-filter input,
    .form-filter select {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 14px;
    }

    .btn-container {
        display: flex;
        justify-content: flex-end;
    }

    .btn-primary {
        background-color: #007bff;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        transition: background-color 0.3s;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    @media (max-width: 768px) {
        .form-filter div {
            flex: 100%;
        }
    }
    </style>
   
@endsection

@section('content')
<div class="container" style="direction: rtl; font-family: 'Cairo', sans-serif;">

    {{-- Card 1: نموذج الفلترة --}}
    <div class="form-card">
    <form action="{{ route('journal.generalLedger') }}" method="GET" class="form-filter">
        <div>
            <label>من تاريخ:</label>
            <input type="date" name="fromDate" value="{{ request('fromDate') }}">
        </div>
        <div>
            <label>إلى تاريخ:</label>
            <input type="date" name="toDate" value="{{ request('toDate') }}">
        </div>
        <div>
            <label>الحساب:</label>
            <select name="account_id">
                <option value="">-- اختر حساب --</option>
                @foreach ($accounts as $accountOption)
                    <option value="{{ $accountOption->id }}" {{ request('account_id') == $accountOption->id ? 'selected' : '' }}>
                        {{ $accountOption->name }} ({{ $accountOption->code }})
                    </option>
                @endforeach
            </select>
        </div>
        <div class="btn-container">
            <button type="submit" class="btn btn-primary">عرض التقرير</button>
        </div>
    </form>
</div>

    {{-- Card 2: بيانات التقرير --}}
    @if(isset($entries) && $entries->count())
    <div class="data-card">
        <div class="report-header">
            <h2>📘 الأستاذ العام</h2>
            <div>
                <p>الفترة من <strong>{{ $from_date }}</strong> إلى <strong>{{ $to_date }}</strong></p>
                <p>🧾 الحساب: <strong>{{ $account->name ?? "" }} ({{ $account->code ?? "" }})</strong></p>
            </div>
        </div>

        <div class="table-responsive">
        <table class="table table-bordered text-center">
                    <thead class="table-light">
                        <tr>
                            <th>التاريخ</th>
                            <th>الوصف</th>
                            <th>المرجع</th>
                            <th>مدين</th>
                            <th>دائن</th>
                            <th>الرصيد المدين</th>
                            <th>الرصيد الدائن</th>
                            <th>مجموع الرصيد</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php 
                            $debitTotal = 0;
                            $creditTotal = 0;
                            $balanceTotal = 0;
                        @endphp
                        @foreach($entries as $entry)
                            @php
                                $debit = $entry->debit ?? 0;
                                $credit = $entry->credit ?? 0;
                                $balance = $debit - $credit;

                                $debitTotal += $debit;
                                $creditTotal += $credit;
                                $balanceTotal += $balance;
                            @endphp
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($entry->date)->format('Y-m-d') }}</td>
                                <td>{{ $entry->description }}</td>
                                <td>{{ $entry->reference }}</td>
                                <td>{{ number_format($debit, 2) }}</td>
                                <td>{{ number_format($credit, 2) }}</td>
                                <td>{{ number_format($debitTotal, 2) }}</td>
                                <td>{{ number_format($creditTotal, 2) }}</td>
                                <td>{{ number_format($balanceTotal, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-light">
                        <tr>
                            <th colspan="3">الإجمالي</th>
                            <th>{{ number_format($debitTotal, 2) }}</th>
                            <th>{{ number_format($creditTotal, 2) }}</th>
                            <th colspan="2"></th>
                            <th>{{ number_format($balanceTotal, 2) }}</th>
                        </tr>
                    </tfoot>
                </table>
        </div>
    </div>
    @else
        <p class="text-center">لا توجد بيانات لعرضها.</p>
    @endif

</div>
@endsection
