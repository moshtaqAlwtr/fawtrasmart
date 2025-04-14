@extends('master')

@section('title')
    تقرير أرصدة العملاء
@stop

@section('css')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/customer.css') }}">
@endsection

@section('content')
    <!-- Page Header -->
    <div class="page-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12">
                    <h2 class="content-header-title float-start mb-0">تقرير أرصدة العملاء</h2>
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="">الرئيسية</a></li>
                            <li class="breadcrumb-item active">عرض </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>


        <!-- Stats Cards -->
<div class="card">
    <div class="card-body">

        <div class="row mb-4">
            <div class="col-md-3">
                <div class="stats-card">
                    <div class="icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3>{{ number_format($totalClients) }}</h3>
                    <p>إجمالي العملاء</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card">
                    <div class="icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <h3>{{ number_format($totalSales, 2) }}</h3>
                    <p>إجمالي المبيعات</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card">
                    <div class="icon">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                    <h3>{{ number_format($totalPayments, 2) }}</h3>
                    <p>إجمالي المدفوعات</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card">
                    <div class="icon">
                        <i class="fas fa-balance-scale"></i>
                    </div>
                    <h3>{{ number_format($totalBalance, 2) }}</h3>
                    <p>إجمالي الأرصدة</p>
                </div>
            </div>
        </div>
    </div>
</div>
        <div class="card mb-4">
            <div class="card-body">
                <div class="action-buttons text-end">
                    <button class="btn btn-success" onclick="window.print()"><i class="fas fa-print"></i> طباعة</button>
                    <button class="btn btn-primary" onclick="exportToExcel()"><i class="fas fa-file-excel"></i> تصدير إلى Excel</button>
                </div>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="card">
            <div class="card-body">
                <form id="filterForm" method="GET" action="{{ route('ClientReport.customerBalances') }}">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="date-from" class="form-label">التاريخ من:</label>
                                <input type="date" id="date-from" name="date_from" class="form-control"
                                    value="{{ request('date_from') }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="date-to" class="form-label">التاريخ إلى:</label>
                                <input type="date" id="date-to" name="date_to" class="form-control"
                                    value="{{ request('date_to') }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="client-category" class="form-label">تصنيف العميل:</label>
                                <select id="client-category" name="client_category" class="form-control">
                                    <option value="">الكل</option>
                                    <option value="عميل فردي" {{ request('client_category') == 'عميل فردي' ? 'selected' : '' }}>
                                        عميل فردي</option>
                                    <option value="مؤسسة" {{ request('client_category') == 'مؤسسة' ? 'selected' : '' }}>مؤسسة
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="client" class="form-label">العميل:</label>
                                <select id="client" name="client" class="form-control">
                                    <option value="">الكل</option>
                                    @foreach ($clients as $client)
                                        <option value="{{ $client->id }}"
                                            {{ request('client') == $client->id ? 'selected' : '' }}>
                                            {{ $client->trade_name ?? $client->first_name . ' ' . $client->last_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="employee" class="form-label">الموظف:</label>
                                <select id="employee" name="employee" class="form-control">
                                    <option value="">الكل</option>
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->id }}"
                                            {{ request('employee') == $employee->id ? 'selected' : '' }}>
                                            {{ $employee->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="branch" class="form-label">الفرع:</label>
                                <select id="branch" name="branch" class="form-control">
                                    <option value="">الكل</option>
                                    @foreach ($branches as $branch)
                                        <option value="{{ $branch->id }}"
                                            {{ request('branch') == $branch->id ? 'selected' : '' }}>
                                            {{ $branch->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="custom-checkbox">
                                <input type="checkbox" id="hide_zero" name="hide_zero" value="1"
                                    {{ request('hide_zero') ? 'checked' : '' }}>
                                <label for="hide_zero">إخفاء الرصيد الصفري</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="custom-checkbox">
                                <input type="checkbox" id="show_details" name="show_details" value="1"
                                    {{ request('show_details') ? 'checked' : '' }}>
                                <label for="show_details">مشاهدة التفاصيل</label>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-12 text-center">
                            <button type="submit" class="btn btn-custom me-2">
                                <i class="fas fa-search me-2"></i>عرض التقرير
                            </button>
                            <a href="{{ route('ClientReport.customerBalances') }}" class="btn btn-secondary">
                                <i class="fas fa-undo me-2"></i>إعادة تعيين
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Results Table -->
        <div class="card">
            <div class="card-body">
                <div class="table">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>الكود</th>
                                    <th>رقم الحساب</th>
                                    <th>الاسم</th>
                                    <th>الفرع</th>
                                    <th>الموظف</th>
                                    <th>الرصيد قبل</th>
                                    <th>إجمالي المبيعات</th>
                                    <th>إجمالي المرتجع</th>
                                    <th>صافي المبيعات</th>
                                    <th>إجمالي المدفوعات</th>
                                    <th>المبلغ المستحق</th>

                                    <th>الرصيد</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    // تعريف متغيرات المجموع الكلي
                                    $totalBalanceBefore = 0;
                                    $totalSales = 0;
                                    $totalReturns = 0;
                                    $totalNetSales = 0;
                                    $totalPayments = 0;
                                    $totalDueValue = 0;
                                    $totalAdjustments = 0;
                                    $totalBalance = 0;
                                @endphp

                                @foreach ($clientBalances as $client)
                                    <tr>
                                        <td>{{ $client['code'] }}</td>
                                        <td>{{ $client['account_number'] }}</td>
                                        <td>{{ $client['name'] }}</td>
                                        <td>{{ $client['branch'] }}</td>

                                        <td>{{ $client['employee'] }}</td>
                                        <td>{{ number_format($client['balance_before'], 2) }}</td>
                                        <td>{{ number_format($client['total_sales'], 2) }}</td>
                                        <td>{{ number_format($client['total_returns'], 2) }}</td>
                                        <td>{{ number_format($client['net_sales'], 2) }}</td>
                                        <td>{{ number_format($client['total_payments'], 2) }}</td>
                                        <td>{{ number_format($client['due_value'], 2) }}</td>

                                        <td>{{ number_format($client['balance'], 2) }}</td>
                                    </tr>

                                    @php
                                        // جمع القيم لكل عمود
                                        $totalBalanceBefore += $client['balance_before'];
                                        $totalSales += $client['total_sales'];
                                        $totalReturns += $client['total_returns'];
                                        $totalNetSales += $client['net_sales'];
                                        $totalPayments += $client['total_payments'];
                                        $totalDueValue += $client['due_value'];
                                        $totalAdjustments += $client['adjustments'];
                                        $totalBalance += $client['balance'];
                                    @endphp
                                @endforeach

                                <!-- صف المجموع الكلي -->
                                <tr style="font-weight: bold; background-color: #f8f9fa;">
                                    <td colspan="4" class="text-end">المجموع الكلي:</td>
                                    <td>{{ number_format($totalBalanceBefore, 2) }}</td>
                                    <td>{{ number_format($totalSales, 2) }}</td>
                                    <td>{{ number_format($totalReturns, 2) }}</td>
                                    <td>{{ number_format($totalNetSales, 2) }}</td>
                                    <td>{{ number_format($totalPayments, 2) }}</td>
                                    <td>{{ number_format($totalDueValue, 2) }}</td>
                                    <td>{{ number_format($totalAdjustments, 2) }}</td>
                                    <td>{{ number_format($totalBalance, 2) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    <!-- Loading Overlay -->

@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            // تهيئة Select2 للقوائم المنسدلة
            $('.form-control').select2({
                dir: "rtl",
                placeholder: "اختر...",
                allowClear: true
            });

            // تهيئة DataTables
            var table = $('.table').DataTable({
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'excel',
                        text: '<i class="fas fa-file-excel"></i> تصدير Excel',
                        className: 'btn btn-success me-2'
                    },
                    {
                        extend: 'print',
                        text: '<i class="fas fa-print"></i> طباعة',
                        className: 'btn btn-primary'
                    }
                ],
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/ar.json'
                },
                pageLength: 10,
                ordering: true,
                responsive: true
            });

            // إظهار شاشة التحميل عند تقديم النموذج
            $('#filterForm').on('submit', function() {
                $('.loading-overlay').css('display', 'flex');
            });

            // إعادة تعيين الفلتر
            $('#resetFilters').click(function() {
                $('#filterForm')[0].reset();
                $('.form-control').trigger('change');
                window.location.href = "{{ route('ClientReport.customerBalances') }}";
            });

            // تحديث حالة الشيك بوكس
            $('.custom-checkbox input[type="checkbox"]').on('change', function() {
                $(this).closest('.custom-checkbox').toggleClass('active');
            });
        });
        function exportToExcel() {
            const table = document.querySelector('table');
            const workbook = XLSX.utils.table_to_book(table, { sheet: "Sheet1" });
            XLSX.writeFile(workbook, 'دليل_العملاء.xlsx');
        }
    </script>
@endsection
