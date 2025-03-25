@extends('master')

@section('title')
    إدارة الإشعارات
@stop

@section('content')
    <div class="container mt-4">
        <div class="card shadow-lg p-4 rounded">
            <!-- عنوان الإشعارات بخلفية بيضاء -->
            <div class="card-header bg-white text-dark border-bottom">
                <h4 class="mb-0 fw-bold">الإشعارات</h4>
            </div>

            <!-- محتوى الكارد -->
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover text-center">
                        <thead class="bg-secondary text-white">
                            <tr>
                                <th>عنوان التنبيه</th>
                                <th>بيانات التنبيه</th>
                                <th>إجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($notifications as $notification)
                                <tr class="align-middle">
                                    <td class="fw-bold text-dark">{{ $notification->title ?? 'بدون عنوان' }}</td>
                                    <td class="fw-bold text-dark">{{ $notification->description ?? 'لا توجد بيانات' }}</td>
                                    <td>
                                        <a href="{{ route('notifications.markAsReadid', $notification->id) }}" 
                                           class="btn btn-sm btn-danger fw-bold">
                                            <i class="fa fa-eye-slash"></i> إخفاء
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-muted fw-bold">لا توجد إشعارات حاليًا</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
