@extends('master')

@section('title')
    تقرير مواعيد العملاء
@stop

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        @media (max-width: 768px) {
            .col-md-3 {
                margin-bottom: 1rem;
            }
        }

        .status-badge {
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 14px;
        }

        .bg-warning {
            background-color: #ffc107;
        }

        .bg-success {
            background-color: #28a745;
        }

        .bg-danger {
            background-color: #dc3545;
        }

        .bg-info {
            background-color: #17a2b8;
        }

        .bg-secondary {
            background-color: #6c757d;
        }

        .btn-custom {
            background-color: #007bff;
            color: #fff;
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .btn-custom:hover {
            background-color: #0056b3;
        }

        .table th, .table td {
            text-align: center;
        }
    </style>
@endsection

@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">تقرير مواعيد العملاء</h2>
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
            <div class="filter-section">
                <div class="row">
                    <div class="col-md-3">
                        <label for="client" class="form-label">العميل:</label>
                        <select id="client" class="form-control">
                            <option value="">الكل</option>
                            @foreach ($clients as $client)
                                <option value="{{ $client->id }}">{{ $client->trade_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="employee" class="form-label">الإجراء:</label>
                        <select id="employee" class="form-control">
                            <option value="">الكل</option>
                            @foreach ($employees as $employee)
                                <option value="{{ $employee->id }}">{{ $employee->full_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="status" class="form-label">الحالة:</label>
                        <select id="status" class="form-control">
                            <option value="">الكل</option>
                            @foreach (App\Models\Appointment::$statusArabicMap as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="date-from" class="form-label">التاريخ من:</label>
                        <input type="date" id="date-from" class="form-control">
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-3">
                        <label for="date-to" class="form-label">التاريخ إلى:</label>
                        <input type="date" id="date-to" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label for="created_by" class="form-label">أنشئ بواسطة:</label>
                        <select id="created_by" class="form-control">
                            <option value="">الكل</option>
                            @foreach ($employees as $employee)
                                <option value="{{ $employee->id }}">{{ $employee->full_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 text-center mt-3">
                        <button class="btn btn-primary me-2">عرض التقرير</button>
                        <button class="btn btn-secondary">إلغاء الفلتر</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="action-buttons text-end mb-3">
                <button class="btn btn-success" onclick="printReport()"><i class="fas fa-print"></i> طباعة</button>
                <button class="btn btn-export export-excel" onclick="exportToExcel()"><i class="fas fa-file-excel"></i> تصدير إلى Excel</button>
            </div>
            <div class="table-responsive">
                <table id="appointments-table" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>اسم العميل</th>
                            <th>التاريخ</th>
                            <th>بداية وقت</th>
                            <th>نهاية الوقت</th>
                            <th>الإجراء</th>
                            <th>الحالة</th>
                            <th>الموظف</th>
                            <th>الملاحظات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($appointments as $appointment)
                            @php
                                $appointmentDate = $appointment->appointment_date ? Carbon\Carbon::parse($appointment->appointment_date) : null; // تحويل السلسلة إلى كائن Carbon
                                $duration = intval($appointment->duration); // تحويل المدة إلى عدد صحيح
                                $endTime = $appointmentDate ? $appointmentDate->copy()->addMinutes($duration) : null; // حساب نهاية الوقت
                            @endphp
                            <tr>
                                <td>{{ $appointment->client->trade_name }}</td>
                                <td>{{ $appointmentDate ? $appointmentDate->format('Y-m-d') : 'غير متوفر' }}</td>
                                <td>{{ $appointmentDate ? $appointmentDate->format('H:i') : 'غير متوفر' }}</td> <!-- بداية الوقت -->
                                <td>{{ $endTime ? $endTime->format('H:i') : 'غير متوفر' }}</td> <!-- نهاية الوقت -->
                                <td>{{ $appointment->action_type }}</td>
                                <td class="{{ $appointment->getStatusColorAttribute() }}">{{ $appointment->statusText }}</td>
                                <td>{{ $appointment->client->employee->full_name }}</td>
                                <td>{{ $appointment->notes }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js"></script>
    <script>
        function exportToExcel() {
            const table = document.getElementById('appointments-table');
            const wb = XLSX.utils.table_to_book(table, { sheet: "Sheet1" });
            XLSX.writeFile(wb, 'تقرير_مواعيد_العملاء.xlsx');
        }

        function printReport() {
            window.print();
        }
    </script>
@endsection
