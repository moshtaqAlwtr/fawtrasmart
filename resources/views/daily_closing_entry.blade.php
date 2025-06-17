@extends('master')

@section('content')
<div class="card">
<div class="container">
    <h4 class="mb-3">تقرير التحصيل اليومي</h4>

    <form method="GET" class="mb-4">
        <div class="row">
            <div class="col-md-3">
                <input type="date" name="date" value="{{ $selectedDate }}" class="form-control">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary">عرض</button>
            </div>
        </div>
    </form>

    <table class="table table-bordered" id="collectionTable">
        <thead class="thead-dark">
            <tr>
                <th>اسم الموظف</th>
                <th>المدفوعات</th>
                <th>سندات القبض</th>
                <th>سندات الصرف</th>
                <th>المحصل</th>
              
            </tr>
        </thead>
        <tbody>
            @foreach($cards as $card)
            <tr>
                <td>{{ $card['name'] }}</td>
                <td>{{ number_format($card['payments'], 2) }}</td>
                <td>{{ number_format($card['receipts'], 2) }}</td>
                <td>{{ number_format($card['expenses'], 2) }}</td>
                <td>{{ number_format($card['total'], 2) }}</td>
              
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        $('#collectionTable').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.25/i18n/Arabic.json"
            }
        });
    });
</script>
@endpush
