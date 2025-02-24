@extends('master')

@section('title')
    تقرير دليل العملاء
@stop

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/report.css') }}">
    <style>
        /* أنماط الأزرار */
        .btn-primary {
            background: linear-gradient(45deg, #6a11cb, #2575fc);
            border: none;
            color: white;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: linear-gradient(45deg, #2575fc, #6a11cb);
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: linear-gradient(45deg, #ff5722, #e64a19);
            border: none;
            color: white;
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            background: linear-gradient(45deg, #e64a19, #ff5722);
            transform: translateY(-2px);
        }

        .btn-success {
            background: linear-gradient(45deg, #4caf50, #388e3c);
            border: none;
            color: white;
            transition: all 0.3s ease;
        }

        .btn-success:hover {
            background: linear-gradient(45deg, #388e3c, #4caf50);
            transform: translateY(-2px);
        }

        .btn-export {
            background: linear-gradient(45deg, #ff9800, #f57c00);
            border: none;
            color: white;
            transition: all 0.3s ease;
        }

        .btn-export:hover {
            background: linear-gradient(45deg, #f57c00, #ff9800);
            transform: translateY(-2px);
        }

        .dropdown-menu {
            border: none;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .dropdown-item {
            transition: all 0.3s ease;
        }

        .dropdown-item:hover {
            background-color: #f0f0f5;
            color: #2575fc;
        }
    </style>
@endsection

@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0"> تقرير دليل العملاء</h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="">الرئيسيه</a></li>
                            <li class="breadcrumb-item active">عرض</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <div class="filter-section">
                <form action="{{ route('ClientReport.customerGuide') }}" method="GET">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="region" class="form-label">المنطقة:</label>
                            <select id="region" name="region" class="form-control">
                                <option>الكل</option>
                                <option>الرياض</option>
                                <option>جدة</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="city" class="form-label">المدينة:</label>
                            <select id="city" name="city" class="form-control">
                                <option>الكل</option>
                                <option>الرياض</option>
                                <option>جدة</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="country" class="form-label">البلد:</label>
                            <input type="text" id="country" name="country" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label for="classification" class="form-label">التصنيف:</label>
                            <select id="classification" name="classification" class="form-control">
                                <option>الكل</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-3">
                            <label for="branch" class="form-label">فرع:</label>
                            <select id="branch" name="branch" class="form-control">
                                <option>الكل</option>
                                @foreach ($branch as $br)
                                    <option value="{{ $br->id }}">{{ $br->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="group-by" class="form-label">تجميع حسب:</label>
                            <select id="group-by" name="group_by" class="form-control">
                                <option>العميل</option>
                                <option>الفرع</option>
                                <option>المدينة</option>
                            </select>
                        </div>
                        <div class="col-md-3 d-flex align-items-center">
                            <input type="checkbox" id="view-details" class="form-check-input me-2">
                            <label for="view-details" class="form-check-label">مشاهدة التفاصيل</label>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12 text-center">
                            <button type="submit" class="btn btn-primary me-2">عرض التقرير</button>
                            <a href="{{ route('ClientReport.customerGuide') }}" class="btn btn-secondary">إلغاء الفلتر</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <div class="action-buttons text-end">
                <button class="btn btn-success"><i class="fas fa-print"></i> طباعة</button>
                <button class="btn btn-export export-excel"><i class="fas fa-file-excel"></i> تصدير إلى Excel</button>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h5 class="text-center mb-4">دليل العملاء - تجميع حسب العميل</h5>
            <p class="text-center">الوقت: {{ now()->format('H:i d/m/Y') }}</p>
            <p class="text-center">مؤسسة أعمال خاصة للتجارة</p>
            <p class="text-center">صاحب الحساب: {{ auth()->user()->name }}</p>

            <div class="table-responsive">
                <table class="table table-striped table-hover text-center">
                    <thead class="thead-light">
                        <tr>
                            <th>الكود</th>
                            <th>الاسم</th>
                            <th>المنطقة</th>
                            <th>العنوان</th>
                            <th>الهاتف</th>
                            <th>جوال</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($clients as $client)
                            <tr>
                                <td>{{ $client->code }}</td>
                                <td>{{ $client->trade_name }}</td>
                                <td>{{ $client->region }}</td>
                                <td>{{ $client->getFullAddressAttribute() }}</td>
                                <td>{{ $client->phone }}</td>
                                <td>{{ $client->mobile }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.4/xlsx.full.min.js"></script>
    <script>
        function exportToExcel() {
            // تحديد الجدول
            const table = document.querySelector('table');
            const workbook = XLSX.utils.table_to_book(table, { sheet: "Sheet1" });

            // تصدير الملف
            XLSX.writeFile(workbook, 'دليل_العملاء.xlsx');
        }

        // ربط الزر بالدالة
        document.querySelector('.export-excel').addEventListener('click', exportToExcel);
    </script>
@endsection
