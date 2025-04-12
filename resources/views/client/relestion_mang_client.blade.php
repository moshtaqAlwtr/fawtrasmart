@extends('layouts.blank')

@section('content')
    <style>
        .status-card {
            transition: all 0.3s ease;
            border-left: 4px solid;
        }

        .status-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .status-badge {
            font-size: 0.8rem;
            padding: 0.35rem 0.75rem;
        }

        .timeline {
            position: relative;
            padding-left: 2rem;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 10px;
            top: 0;
            bottom: 0;
            width: 2px;
            background-color: #e9ecef;
        }

        .timeline-item {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            left: -32px;
            top: 5px;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            border: 2px solid #fff;
            z-index: 1;
        }

        .timeline-item-primary::before {
            background-color: #007bff;
        }

        .timeline-item-success::before {
            background-color: #28a745;
        }

        .timeline-item-warning::before {
            background-color: #ffc107;
        }

        .timeline-item-danger::before {
            background-color: #dc3545;
        }

        .status-actions .btn {
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .status-card:hover .status-actions .btn {
            opacity: 1;
        }

        .color-preview {
            width: 25px;
            height: 25px;
            border-radius: 4px;
            display: inline-block;
            margin-right: 8px;
            border: 1px solid #dee2e6;
        }
    </style>

    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h1 class="h3 mb-0 text-gray-800">إدارة حالات العملاء</h1>

                    <div>
                        <button class="btn btn-primary" data-toggle="modal" data-target="#addStatusModal">
                            <i class="fas fa-plus"></i> إضافة حالة جديدة
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- بطاقات عرض الحالات -->
        <div class="row">
            @foreach($statuses as $status)
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card status-card shadow-sm h-100 border-left-{{ $status->color }}">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="card-title mb-0">
                                    <span class="color-preview" style="background-color: {{ $status->color_hex ?? '#6c757d' }}"></span>
                                    {{ $status->name }}
                                </h5>

                                <div class="status-actions">
                                    <button class="btn btn-sm btn-outline-secondary edit-status"
                                            data-id="{{ $status->id }}"
                                            data-name="{{ $status->name }}"
                                            data-color="{{ $status->color }}"
                                            data-color_hex="{{ $status->color_hex ?? '' }}"
                                            data-state="{{ $status->state }}">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    <button class="btn btn-sm btn-outline-danger delete-status"
                                            data-id="{{ $status->id }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <span class="badge status-badge bg-{{ $status->color }}">
                                    {{ $status->state == 1 ? 'نشط' : 'غير نشط' }}
                                </span>

                                <small class="text-muted">
                                    {{ $status->clients_count }} عميل
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- جدول العملاء حسب الحالة -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">توزيع العملاء حسب الحالة</h6>

                        <div class="dropdown">
                            <button class="btn btn-outline-secondary dropdown-toggle" type="button"
                                    id="statusFilterDropdown" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                تصفية حسب الحالة
                            </button>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="statusFilterDropdown">
                                <a class="dropdown-item" href="#" data-status="all">جميع الحالات</a>
                                @foreach($statuses as $status)
                                    <a class="dropdown-item" href="#" data-status="{{ $status->id }}">
                                        {{ $status->name }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="clientsTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>الاسم التجاري</th>
                                        <th>الهاتف</th>
                                        <th>الحالة</th>
                                        <th>آخر تحديث</th>
                                        <th>الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($clients as $client)
                                        <tr>
                                            <td>{{ $client->code }}</td>
                                            <td>{{ $client->trade_name }}</td>
                                            <td>{{ $client->phone }}</td>
                                            <td>
                                                <span class="badge bg-{{ $client->latestStatus->color ?? 'secondary' }}">
                                                    {{ $client->latestStatus->name ?? 'غير محدد' }}
                                                </span>
                                            </td>
                                            <td>
                                                @if($client->latestStatus)
                                                    {{ $client->latestStatus->pivot->created_at->diffForHumans() }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary change-client-status"
                                                        data-client-id="{{ $client->id }}"
                                                        data-current-status="{{ $client->latestStatus->id ?? '' }}">
                                                    تغيير الحالة
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- سجل تغييرات الحالة -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">سجل تغييرات الحالة</h6>
                    </div>

                    <div class="card-body">
                        <div class="timeline">
                            @foreach($statusHistory as $history)
                                <div class="timeline-item timeline-item-{{ $history->color }}">
                                    <div class="card mb-3 shadow-sm">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <h6 class="mb-1">
                                                        <strong>{{ $history->client->trade_name }}</strong>
                                                    </h6>
                                                    <p class="mb-1">تم تغيير الحالة إلى
                                                        <span class="badge bg-{{ $history->color }}">
                                                            {{ $history->name }}
                                                        </span>
                                                    </p>
                                                    <small class="text-muted">
                                                        {{ $history->pivot->created_at->diffForHumans() }}
                                                    </small>
                                                </div>

                                                <div>
                                                    <small class="text-muted">
                                                        بواسطة: {{ $history->pivot->user->name ?? 'النظام' }}
                                                    </small>
                                                </div>
                                            </div>

                                            @if($history->pivot->notes)
                                                <div class="mt-2 p-2 bg-light rounded">
                                                    <p class="mb-0">{{ $history->pivot->notes }}</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-3">
                            {{ $statusHistory->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal إضافة حالة جديدة -->
    <div class="modal fade" id="addStatusModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">إضافة حالة جديدة</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form id="addStatusForm" action="{{ route('statuses.store') }}" method="POST">
                    @csrf

                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">اسم الحالة</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>

                        <div class="form-group">
                            <label for="color">لون الحالة</label>
                            <select class="form-control" id="color" name="color" required>
                                <option value="primary">أزرق (Primary)</option>
                                <option value="secondary">رمادي (Secondary)</option>
                                <option value="success">أخضر (Success)</option>
                                <option value="danger">أحمر (Danger)</option>
                                <option value="warning">أصفر (Warning)</option>
                                <option value="info">سماوي (Info)</option>
                                <option value="dark">أسود (Dark)</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="color_hex">أو اختر لون مخصص</label>
                            <input type="color" class="form-control" id="color_hex" name="color_hex">
                        </div>

                        <div class="form-group">
                            <label for="state">حالة النشاط</label>
                            <select class="form-control" id="state" name="state" required>
                                <option value="1">نشط</option>
                                <option value="0">غير نشط</option>
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                        <button type="submit" class="btn btn-primary">حفظ الحالة</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal تعديل الحالة -->
    <div class="modal fade" id="editStatusModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">تعديل الحالة</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form id="editStatusForm" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="modal-body">
                        <div class="form-group">
                            <label for="edit_name">اسم الحالة</label>
                            <input type="text" class="form-control" id="edit_name" name="name" required>
                        </div>

                        <div class="form-group">
                            <label for="edit_color">لون الحالة</label>
                            <select class="form-control" id="edit_color" name="color" required>
                                <option value="primary">أزرق (Primary)</option>
                                <option value="secondary">رمادي (Secondary)</option>
                                <option value="success">أخضر (Success)</option>
                                <option value="danger">أحمر (Danger)</option>
                                <option value="warning">أصفر (Warning)</option>
                                <option value="info">سماوي (Info)</option>
                                <option value="dark">أسود (Dark)</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="edit_color_hex">أو اختر لون مخصص</label>
                            <input type="color" class="form-control" id="edit_color_hex" name="color_hex">
                        </div>

                        <div class="form-group">
                            <label for="edit_state">حالة النشاط</label>
                            <select class="form-control" id="edit_state" name="state" required>
                                <option value="1">نشط</option>
                                <option value="0">غير نشط</option>
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                        <button type="submit" class="btn btn-primary">حفظ التغييرات</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal تغيير حالة العميل -->
    <div class="modal fade" id="changeClientStatusModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">تغيير حالة العميل</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form id="changeClientStatusForm" method="POST">
                    @csrf

                    <div class="modal-body">
                        <input type="hidden" id="client_id" name="client_id">

                        <div class="form-group">
                            <label for="status_id">الحالة الجديدة</label>
                            <select class="form-control" id="status_id" name="status_id" required>
                                @foreach($statuses as $status)
                                    <option value="{{ $status->id }}" data-color="{{ $status->color }}">
                                        {{ $status->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="notes">ملاحظات (اختياري)</label>
                            <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                        <button type="submit" class="btn btn-primary">حفظ التغيير</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // تهيئة DataTable
            $('#clientsTable').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.10.25/i18n/Arabic.json'
                },
                order: [[4, 'desc']]
            });

            // فتح modal تعديل الحالة
            $('.edit-status').click(function() {
                var id = $(this).data('id');
                var name = $(this).data('name');
                var color = $(this).data('color');
                var color_hex = $(this).data('color_hex');
                var state = $(this).data('state');

                $('#editStatusForm').attr('action', '/statuses/' + id);
                $('#edit_name').val(name);
                $('#edit_color').val(color);
                $('#edit_color_hex').val(color_hex || '#000000');
                $('#edit_state').val(state);

                $('#editStatusModal').modal('show');
            });

            // فتح modal حذف الحالة
            $('.delete-status').click(function() {
                var id = $(this).data('id');

                Swal.fire({
                    title: 'هل أنت متأكد؟',
                    text: "لن تتمكن من استعادة هذه الحالة!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'نعم، احذفها!',
                    cancelButtonText: 'إلغاء'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/statuses/' + id,
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                Swal.fire(
                                    'تم الحذف!',
                                    'تم حذف الحالة بنجاح.',
                                    'success'
                                ).then(() => {
                                    location.reload();
                                });
                            },
                            error: function() {
                                Swal.fire(
                                    'خطأ!',
                                    'حدث خطأ أثناء محاولة حذف الحالة.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            });

            // تصفية الجدول حسب الحالة
            $('[data-status]').click(function(e) {
                e.preventDefault();
                var status = $(this).data('status');

                if (status === 'all') {
                    $('#clientsTable tbody tr').show();
                } else {
                    $('#clientsTable tbody tr').each(function() {
                        var rowStatus = $(this).find('td:eq(3) span').text().trim();
                        var targetStatus = $('[data-status="' + status + '"]').text().trim();

                        if (rowStatus === targetStatus) {
                            $(this).show();
                        } else {
                            $(this).hide();
                        }
                    });
                }

                $('#statusFilterDropdown').text($(this).text());
            });

            // فتح modal تغيير حالة العميل
            $('.change-client-status').click(function() {
                var clientId = $(this).data('client-id');
                var currentStatus = $(this).data('current-status');

                $('#client_id').val(clientId);
                $('#status_id').val(currentStatus);
                $('#changeClientStatusForm').attr('action', '/clients/' + clientId + '/status');

                $('#changeClientStatusModal').modal('show');
            });

            // عرض معاينة اللون عند تغييره
            $('#color, #edit_color').change(function() {
                var color = $(this).val();
                var colorHexMap = {
                    'primary': '#007bff',
                    'secondary': '#6c757d',
                    'success': '#28a745',
                    'danger': '#dc3545',
                    'warning': '#ffc107',
                    'info': '#17a2b8',
                    'dark': '#343a40'
                };

                $(this).siblings('input[type="color"]').val(colorHexMap[color]);
            });

            // إرسال النموذج عبر Ajax لإضافة حالة جديدة
            $('#addStatusForm').submit(function(e) {
                e.preventDefault();

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#addStatusModal').modal('hide');
                        Swal.fire(
                            'تم!',
                            'تم إضافة الحالة بنجاح.',
                            'success'
                        ).then(() => {
                            location.reload();
                        });
                    },
                    error: function() {
                        Swal.fire(
                            'خطأ!',
                            'حدث خطأ أثناء محاولة إضافة الحالة.',
                            'error'
                        );
                    }
                });
            });

            // إرسال النموذج عبر Ajax لتعديل الحالة
            $('#editStatusForm').submit(function(e) {
                e.preventDefault();

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#editStatusModal').modal('hide');
                        Swal.fire(
                            'تم!',
                            'تم تحديث الحالة بنجاح.',
                            'success'
                        ).then(() => {
                            location.reload();
                        });
                    },
                    error: function() {
                        Swal.fire(
                            'خطأ!',
                            'حدث خطأ أثناء محاولة تحديث الحالة.',
                            'error'
                        );
                    }
                });
            });

            // إرسال النموذج عبر Ajax لتغيير حالة العميل
            $('#changeClientStatusForm').submit(function(e) {
                e.preventDefault();

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#changeClientStatusModal').modal('hide');
                        Swal.fire(
                            'تم!',
                            'تم تغيير حالة العميل بنجاح.',
                            'success'
                        ).then(() => {
                            location.reload();
                        });
                    },
                    error: function() {
                        Swal.fire(
                            'خطأ!',
                            'حدث خطأ أثناء محاولة تغيير الحالة.',
                            'error'
                        );
                    }
                });
            });
        });
    </script>
@endsection
