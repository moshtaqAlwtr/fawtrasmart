@extends('master')

@section('title')
    تقرير شحن الارصدة
@stop

@section('css')
    <style>
        .report-card {
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin-bottom: 30px;
        }

        .report-header {
            background: linear-gradient(135deg, #3498db, #2c3e50);
            color: white;
            padding: 15px 20px;
        }

        .report-body {
            background: white;
            padding: 20px;
        }

        .filter-form .form-control {
            border-radius: 5px;
            border: 1px solid #ddd;
            height: 45px;
        }

        .filter-form label {
            font-weight: 600;
            margin-bottom: 8px;
            color: #2c3e50;
        }

        .table-responsive {
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .balance-table {
            width: 100%;
            margin-bottom: 0;
        }

        .balance-table thead th {
            background-color: #f8f9fa;
            color: #2c3e50;
            font-weight: 600;
            border-bottom: 2px solid #e9ecef;
            padding: 15px;
            text-align: right;
        }

        .balance-table tbody td {
            padding: 12px 15px;
            border-bottom: 1px solid #e9ecef;
            vertical-align: middle;
        }

        .balance-table tbody tr:hover {
            background-color: #f8f9fa;
        }

        .badge-status {
            padding: 6px 10px;
            border-radius: 20px;
            font-weight: 500;
            font-size: 0.8rem;
        }

        .badge-active {
            background-color: #e3f7ee;
            color: #1abc9c;
        }

        .badge-expired {
            background-color: #fee9e9;
            color: #e74c3c;
        }

        .total-card {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
            margin-top: 20px;
            border-left: 4px solid #3498db;
        }

        .btn-print {
            background: #2c3e50;
            color: white;
            border: none;
            padding: 8px 20px;
            border-radius: 5px;
            transition: all 0.3s;
        }

        .btn-print:hover {
            background: #1a252f;
            color: white;
        }

        .btn-excel {
            background: #1abc9c;
            color: white;
            border: none;
            padding: 8px 20px;
            border-radius: 5px;
            transition: all 0.3s;
        }

        .btn-excel:hover {
            background: #16a085;
            color: white;
        }
    </style>
@endsection

@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">تقرير شحن الأرصدة</h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="">الرئيسية</a></li>
                            <li class="breadcrumb-item active">تقرير شحن الأرصدة</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="report-card">
        <div class="report-header">
            <h5 class="mb-0"><i class="fas fa-filter"></i> نموذج البحث</h5>
        </div>
        <div class="report-body">
            <form action="{{ route('ClientReport.rechargeBalancesReport') }}" method="GET" class="filter-form">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="customer">العميل</label>
                            <select class="form-control select2" id="customer" name="customer">
                                <option value="">جميع العملاء</option>
                                @foreach ($clients as $client)
                                    <option value="{{ $client->id }}"
                                        {{ request('customer') == $client->id ? 'selected' : '' }}>
                                        {{ $client->trade_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="income_type">نوع الرصيد</label>
                            <select class="form-control select2" id="income_type" name="income_type">
                                <option value="">جميع الأنواع</option>
                                @foreach ($types as $type)
                                    <option value="{{ $type->id }}"
                                        {{ request('income_type') == $type->id ? 'selected' : '' }}>
                                        {{ $type->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="date_from">من تاريخ</label>
                            <input type="date" class="form-control" id="date_from" name="date_from"
                                value="{{ request('date_from') }}">
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="date_to">إلى تاريخ</label>
                            <input type="date" class="form-control" id="date_to" name="date_to"
                                value="{{ request('date_to') }}">
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="branch">الفرع</label>
                            <select class="form-control select2" id="branch" name="branch">
                                <option value="">جميع الفروع</option>
                                @foreach ($branches as $branch)
                                    <option value="{{ $branch->id }}"
                                        {{ request('branch') == $branch->id ? 'selected' : '' }}>
                                        {{ $branch->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-12 text-right">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> بحث
                        </button>
                        <a href="{{ route('ClientReport.rechargeBalancesReport') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-redo"></i> إعادة تعيين
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="report-card">
        <div class="report-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-file-invoice-dollar"></i> نتائج التقرير</h5>
            <div>
                <button class="btn-print mr-2">
                    <i class="fas fa-print"></i> طباعة
                </button>
                <button class="btn-excel">
                    <i class="fas fa-file-excel"></i> تصدير Excel
                </button>
            </div>
        </div>
        <div class="report-body">
            <div class="table-responsive">
                <table class="balance-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>العميل</th>
                            <th>نوع الرصيد</th>
                            <th>القيمة</th>
                            <th>تاريخ البدء</th>
                            <th>تاريخ الانتهاء</th>
                            <th>الفرع</th>
                            <th>الحالة</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($charges as $charge)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $charge->client->trade_name ?? 'غير محدد' }}</td>
                                <td>{{ $charge->balanceType->name ?? 'غير محدد' }}</td>
                                <td>{{ number_format($charge->value, 2) }} ر.س</td>
                                <td>{{ $charge->start_date ? date('Y-m-d', strtotime($charge->start_date)) : '-' }}</td>
                                <td>{{ $charge->end_date ? date('Y-m-d', strtotime($charge->end_date)) : '-' }}</td>
                                <td>{{ $charge->client->branch->name ?? 'غير محدد' }}</td>
                                <td>
                                    @if ($charge->status == 1)
                                        <span class="badge badge-success">نشط</span>
                                    @else
                                        <span class="badge badge-danger">غير نشط</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">لا توجد بيانات متاحة</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="total-card">
                <div class="row">
                    <div class="col-md-6">
                        <h5 class="mb-0">إجمالي شحن الأرصدة:</h5>
                    </div>
                    <div class="col-md-6 text-left">
                        <h5 class="mb-0">{{ number_format($totalAmount, 2) }} ر.س</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // Initialize select2
            $('.select2').select2({
                placeholder: "اختر...",
                allowClear: true,
                width: '100%'
            });

            // Print button functionality
            $('.btn-print').click(function() {
                window.print();
            });

            // Excel export functionality
            $('.btn-excel').click(function() {
                // You can implement Excel export here using a package like Laravel Excel
                // or redirect to a route that handles the export
                alert('سيتم تنزيل ملف Excel');
            });
        });
    </script>
@endsection
