@extends('master')

@section('title')
    تقرير مبيعات البنود
@stop

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/report.css') }}">
    <style>
        body {
            direction: rtl;
            text-align: right;
            font-family: 'Tajawal', sans-serif;
            background-color: #f8f9fa;
        }

        .card {
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .card-title {
            font-weight: bold;
            color: #2c3e50;
        }

        .table thead th {
            background-color: #1e90ff;
            color: white;
            font-weight: bold;
        }

        .table tbody td {
            vertical-align: middle;
        }

        .table-hover tbody tr:hover {
            background-color: #f1f8ff;
        }

        .btn-primary {
            background: linear-gradient(135deg, #1e90ff, #00bfff);
            border: none;
            padding: 10px 20px;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            opacity: 0.9;
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: linear-gradient(135deg, #6c757d, #868e96);
            border: none;
            padding: 10px 20px;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            opacity: 0.9;
            transform: translateY(-2px);
        }

        .text-muted {
            color: #6c757d !important;
        }

        .report-link {
            padding: 5px 10px;
            border-radius: 5px;
            margin-left: 5px;
            text-decoration: none;
        }

        .report-link.details {
            background-color: #1e90ff;
            color: white;
        }

        .report-link.summary {
            background-color: #28a745;
            color: white;
        }

        .report-link:hover {
            opacity: 0.8;
        }
    </style>
@endsection

@section('content')
<div class="container-fluid mt-4">
    <div class="card shadow">
        <div class="card-body">
            <h5 class="card-title">
                @if($isSummary)
                    <i class="fas fa-clipboard-list"></i> ملخص تقرير مبيعات البنود حسب
                @else
                    <i class="fas fa-file-alt"></i> تفاصيل تقرير مبيعات البنود حسب
                @endif
                {{ match($filter) {
                    'item' => 'البند',
                    'category' => 'التصنيف',
                    'employee' => 'الموظف',
                    'sales_manager' => 'مندوب المبيعات',
                    'client' => 'العميل',
                    default => 'البند'
                } }}
            </h5>

            <form action="{{ route('salesReports.byItem') }}" method="GET">
                <input type="hidden" name="filter" value="{{ $filter }}">
                @if($isSummary)
                    <input type="hidden" name="summary" value="1">
                @endif

                <div class="row g-3">
                    <!-- حالة الفاتورة -->
                    <div class="col-md-3">
                        <label for="status"><i class="fas fa-receipt"></i> حالة الفاتورة</label>
                        <select name="status" class="form-control">
                            <option value="">الكل</option>
                            <option value="فاتورة" {{ request('status') == 'فاتورة' ? 'selected' : '' }}>فاتورة</option>
                            <option value="مسودة" {{ request('status') == 'مسودة' ? 'selected' : '' }}>مسودة</option>
                        </select>
                    </div>

                    <!-- البند -->
                    <div class="col-md-3">
                        <label for="item"><i class="fas fa-box"></i> البند</label>
                        <select name="item" class="form-control">
                            <option value="">الكل</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" {{ request('item') == $product->id ? 'selected' : '' }}>{{ $product->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- الموظف -->
                    <div class="col-md-3">
                        <label for="employee"><i class="fas fa-user-tie"></i> الموظف</label>
                        <select name="employee" class="form-control">
                            <option value="">الكل</option>
                            @foreach($employees as $employee)
                                <option value="{{ $employee->id }}" {{ request('employee') == $employee->id ? 'selected' : '' }}>{{ $employee->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- العميل -->
                    <div class="col-md-3">
                        <label for="client"><i class="fas fa-user"></i> العميل</label>
                        <select name="client" class="form-control">
                            <option value="">اختر العميل</option>
                            @foreach($clients as $client)
                                <option value="{{ $client->id }}" {{ request('client') == $client->id ? 'selected' : '' }}>{{ $client->trade_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- الفرع -->
                    <div class="col-md-3">
                        <label for="branch"><i class="fas fa-building"></i> الفرع</label>
                        <select name="branch" class="form-control">
                            <option value="">الكل</option>
                            @foreach($branches as $branch)
                                <option value="{{ $branch->id }}" {{ request('branch') == $branch->id ? 'selected' : '' }}>{{ $branch->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- التصنيف -->
                    <div class="col-md-3">
                        <label for="category"><i class="fas fa-layer-group"></i> التصنيف</label>
                        <select name="category" class="form-control">
                            <option value="">اختر التصنيف</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- المخزن -->
                    <div class="col-md-3">
                        <label for="storehouse"><i class="fas fa-warehouse"></i> المخزن</label>
                        <select name="storehouse" class="form-control">
                            <option value="">اختر المخزن</option>
                            @foreach($storehouses as $storehouse)
                                <option value="{{ $storehouse->id }}" {{ request('storehouse') == $storehouse->id ? 'selected' : '' }}>{{ $storehouse->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- نوع الفاتورة -->
                    <div class="col-md-3">
                        <label for="invoice_type"><i class="fas fa-file-invoice"></i> نوع الفاتورة</label>
                        <select name="invoice_type" class="form-control">
                            <option value="">الكل</option>
                            <option value="1" {{ request('invoice_type') == '1' ? 'selected' : '' }}>مرتجع</option>
                            <option value="2" {{ request('invoice_type') == '2' ? 'selected' : '' }}>اشعار مدين</option>
                            <option value="3" {{ request('invoice_type') == '3' ? 'selected' : '' }}>اشعار دائن</option>
                        </select>
                    </div>

                    <!-- الفترة من / إلى -->
                    <div class="col-md-3">
                        <label for="from_date"><i class="fas fa-calendar-alt"></i> من تاريخ</label>
                        <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}">
                    </div>
                    <div class="col-md-3">
                        <label for="to_date"><i class="fas fa-calendar-alt"></i> إلى تاريخ</label>
                        <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}">
                    </div>

                    <!-- زر البحث -->
                    <div class="col-md-12 text-center mt-4">
                        <div class="row g-3 align-items-center">
                            <!-- زر البحث -->
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-search"></i> عرض التقرير
                                </button>
                            </div>

                            <!-- زر إعادة التعيين -->
                            <div class="col-md-3">
                                <a href="{{ route('salesReports.byItem', ['filter' => $filter, 'summary' => $isSummary ? '1' : null]) }}" class="btn btn-warning w-100">
                                    <i class="fas fa-sync-alt"></i> إعادة تعيين
                                </a>
                            </div>

                            <!-- دروب داون للفترة -->
                            <div class="col-md-3">
                                <div class="dropdown">
                                    <button class="btn btn-info dropdown-toggle w-100" type="button" id="periodDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                        اختر الفترة
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="periodDropdown">
                                        <li>
                                            <a class="dropdown-item" href="#" onclick="selectPeriod('')">الكل</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#" onclick="selectPeriod('daily')">يومي</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#" onclick="selectPeriod('weekly')">أسبوعي</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#" onclick="selectPeriod('monthly')">شهري</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#" onclick="selectPeriod('yearly')">سنوي</a>
                                        </li>
                                    </ul>
                                    <input type="hidden" name="period" id="periodInput" value="{{ request('period') }}">
                                </div>
                            </div>

                            <!-- زر تصدير إلى Excel -->
                            <div class="col-md-3">
                                <button type="button" class="btn btn-success w-100" id="exportExcel">
                                    <i class="fas fa-file-excel"></i> تصدير إلى Excel
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Results Section -->
    <div class="card mt-4">
        <div class="card-body">
            <table class="table table-hover table-striped" id="reportTable">
                <thead class="thead-dark">
                    <tr>
                        <th>المعرف</th>
                        <th>كود المنتج</th>
                        <th>التاريخ</th>
                        <th>الموظف</th>
                        <th>الفاتورة</th>
                        <th>العميل</th>
                        <th>سعر الوحدة</th>
                        <th>الكمية</th>
                        <th>الخصم</th>
                        <th>الاجمالي</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        // تجميع البيانات حسب الاسم أولاً
                        $groupedData = [];
                        foreach($reportData as $data) {
                            $groupedData[$data['name']][] = $data;
                        }

                        $grandTotalQuantity = 0;
                        $grandTotalDiscount = 0;
                        $grandTotalAmount = 0;
                    @endphp

                    @forelse($groupedData as $name => $items)
                        @php
                            $groupTotalQuantity = 0;
                            $groupTotalDiscount = 0;
                            $groupTotalAmount = 0;
                        @endphp

                        <tr class="table-primary">
                            <td colspan="10" class="text-center font-weight-bold">
                                {{ match($filter) {
                                    'item' => 'البند: ',
                                    'category' => 'التصنيف: ',
                                    'employee' => 'الموظف: ',
                                    'sales_manager' => 'مندوب المبيعات: ',
                                    'client' => 'العميل: ',
                                    default => ''
                                } }}{{ $name }}
                            </td>
                        </tr>

                        @foreach($items as $data)
                            <tr>
                                <td>{{ $data['id'] }}</td>
                                <td>{{ $data['product_code'] }}</td>
                                <td>{{ $data['date'] }}</td>
                                <td>{{ $data['employee'] }}</td>
                                <td>{{ $data['invoice'] }}</td>
                                <td>{{ $data['client'] }}</td>
                                <td>{{ number_format($data['unit_price'], 2) }}</td>
                                <td>{{ $data['quantity'] }}</td>
                                <td>{{ number_format($data['discount'], 2) }}</td>
                                <td>{{ number_format($data['total'], 2) }}</td>
                            </tr>

                            @php
                                $groupTotalQuantity += $data['quantity'];
                                $groupTotalDiscount += $data['discount'];
                                $groupTotalAmount += $data['total'];

                                $grandTotalQuantity += $data['quantity'];
                                $grandTotalDiscount += $data['discount'];
                                $grandTotalAmount += $data['total'];
                            @endphp
                        @endforeach

                        <tr class="table-secondary">
                            <td colspan="7" class="text-end font-weight-bold">مجموع {{ $name }}</td>
                            <td>{{ number_format($groupTotalQuantity, 2) }}</td>
                            <td>{{ number_format($groupTotalDiscount, 2) }}</td>
                            <td>{{ number_format($groupTotalAmount, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center text-muted">لا توجد بيانات لعرضها</td>
                        </tr>
                    @endforelse

                    <tr class="table-success">
                        <td colspan="7" class="text-end font-weight-bold">المجموع العام</td>
                        <td>{{ number_format($grandTotalQuantity, 2) }}</td>
                        <td>{{ number_format($grandTotalDiscount, 2) }}</td>
                        <td>{{ number_format($grandTotalAmount, 2) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.5/xlsx.full.min.js"></script>
    <script>
        // دالة لتصدير الجدول إلى Excel
        document.getElementById('exportExcel').addEventListener('click', function() {
            const table = document.getElementById('reportTable');
            const wb = XLSX.utils.table_to_book(table, { sheet: "تقرير المبيعات" });
            XLSX.writeFile(wb, 'تقرير_المبيعات.xlsx');
        });

        // دالة لتحديد الفترة
        function selectPeriod(period) {
            document.getElementById('periodInput').value = period;
            document.getElementById('periodDropdown').innerText = period ? {
                'daily': 'يومي',
                'weekly': 'أسبوعي',
                'monthly': 'شهري',
                'yearly': 'سنوي'
            }[period] : 'اختر الفترة';
        }

        // تحديث النص عند تحميل الصفحة
        document.addEventListener('DOMContentLoaded', function() {
            const period = document.getElementById('periodInput').value;
            if (period) {
                selectPeriod(period);
            }
        });
    </script>
@endsection
