@extends('master')

@section('title')
    تقرير مبيعات البنود
@stop

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
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
    </style>
@endsection

@section('content')
<div class="container-fluid mt-4">
    <div class="card shadow">
        <div class="card-body">
            <h5 class="card-title">تقرير مبيعات البنود</h5>
            <form action="{{ route('salesReports.byItem') }}" method="GET">
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
                                <option value="{{ $employee->id }}" {{ request('employee') == $employee->id ? 'selected' : '' }}>{{ $employee->full_name }}</option>
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
                                <a href="{{ route('salesReports.byItem') }}" class="btn btn-warning w-100">
                                    <i class="fas fa-reset"></i> إعادة تعيين
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
                        <th>الاسم</th>
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
                        $currentItem = null;
                        $totalQuantity = 0;
                        $totalDiscount = 0;
                        $totalAmount = 0;
                        $grandTotalQuantity = 0;
                        $grandTotalDiscount = 0;
                        $grandTotalAmount = 0;
                    @endphp
                    @forelse($reportData as $data)
                        @if ($currentItem != $data['name'])
                            @if ($currentItem)

                                <tr class="table-warning">
                                    <td colspan="8" class="text-end"><strong>مجموع البند: {{ $currentItem }}</strong></td>
                                    <td>{{ number_format($totalQuantity, 2) }}</td>
                                    <td>{{ number_format($totalDiscount, 2) }}</td>
                                    <td>{{ number_format($totalAmount, 2) }}</td>
                                </tr>
                                @php
                                    // إعادة تعيين المجاميع للبند الجديد
                                    $totalQuantity = 0;
                                    $totalDiscount = 0;
                                    $totalAmount = 0;
                                @endphp
                            @endif
                            <!-- عرض اسم البند الجديد مع الفترة -->
                            <tr class="table-info">
                                <td colspan="11" class="text-center">
                                    @if (request('filter') == 'item')
                                        <strong>البند: {{ $data['name'] }}</strong>
                                    @elseif (request('filter') == 'category')
                                        <strong>التصنيف: {{ $data['name'] }}</strong>
                                    @elseif (request('filter') == 'brand')
                                        <strong>الماركة: {{ $data['name'] }}</strong>
                                    @elseif (request('filter') == 'employee')
                                        <strong>الموظف: {{ $data['name'] }}</strong>
                                    @elseif (request('filter') == 'sales_manager')
                                        <strong>مندوب المبيعات: {{ $data['name'] }}</strong>
                                    @elseif (request('filter') == 'client')
                                        <strong>العميل: {{ $data['name'] }}</strong>
                                    @endif

                                    @if (request('period') == 'daily')
                                        <br><span class="text-muted">(تاريخ اليوم: {{ Carbon\Carbon::now()->format('Y-m-d') }})</span>
                                    @elseif (request('period') == 'weekly')
                                        <br><span class="text-muted">(الأسبوع الحالي: من {{ Carbon\Carbon::now()->startOfWeek()->format('Y-m-d') }} إلى {{ Carbon\Carbon::now()->endOfWeek()->format('Y-m-d') }})</span>
                                    @elseif (request('period') == 'monthly')
                                        <br><span class="text-muted">(الشهر الحالي: {{ Carbon\Carbon::now()->format('Y-m') }})</span>
                                    @elseif (request('period') == 'yearly')
                                        <br><span class="text-muted">(السنة الحالية: {{ Carbon\Carbon::now()->format('Y') }})</span>
                                    @endif
                                </td>
                            </tr>
                            @php
                                $currentItem = $data['name'];
                            @endphp
                        @endif
                        <!-- عرض تفاصيل البند -->
                        <tr>
                            <td>{{ $data['id'] }}</td>
                            <td>{{ $data['name'] }}</td>
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
                            // حساب المجاميع للبند الحالي
                            $totalQuantity += $data['quantity'];
                            $totalDiscount += $data['discount'];
                            $totalAmount += $data['total'];
                            // حساب المجاميع العامة
                            $grandTotalQuantity += $data['quantity'];
                            $grandTotalDiscount += $data['discount'];
                            $grandTotalAmount += $data['total'];
                        @endphp
                    @empty
                        <tr>
                            <td colspan="11" class="text-center text-muted">لا توجد بيانات لعرضها</td>
                        </tr>
                    @endforelse
                    <!-- عرض المجموع الكلي للبند الأخير -->
                    @if ($currentItem)
                        <tr class="table-warning">
                            <td colspan="8" class="text-end"><strong>مجموع البند: {{ $currentItem }}</strong></td>
                            <td>{{ number_format($totalQuantity, 2) }}</td>
                            <td>{{ number_format($totalDiscount, 2) }}</td>
                            <td>{{ number_format($totalAmount, 2) }}</td>
                        </tr>
                    @endif
                    <!-- عرض المجموع العام -->
                    <tr class="table-success">
                        <td colspan="8" class="text-end"><strong>المجموع العام</strong></td>
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
