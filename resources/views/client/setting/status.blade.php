@extends('master')

@section('title', 'إدارة الحالات')

@section('content')
<div class="card">
<div class="container mt-4">
    <h2 class="mb-4">إدارة الحالات</h2>

    <!-- عرض رسالة نجاح -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- عرض رسالة خطأ -->
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <!-- جدول عرض الحالات -->

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>اسم الحالة</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            @foreach($statuses as $index => $status)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $status->name }}</td>
                    <td>
                        <form action="{{ route('clients.status.delete', $status->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('هل أنت متأكد من الحذف؟')">حذف</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- نموذج إضافة حالة جديدة -->
    <h3 class="mt-4">إضافة حالة جديدة</h3>
    <form action="{{ route('clients.status.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">اسم الحالة:</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary mt-2">إضافة</button>
    </form>
</div>
</div>
@endsection
