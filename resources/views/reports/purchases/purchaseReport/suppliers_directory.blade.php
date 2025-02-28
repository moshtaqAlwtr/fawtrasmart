@extends('master')

@section('title')
    تقرير دليل الموردين
@stop

@section('content')
    <div class="content-header row mb-3">
        <div class="content-header-left col-md-12">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h2 class="content-header-title float-start mb-0">تقارير دليل الموردين </h2>
                </div>
                <div class="col-md-6">
                    <div class="breadcrumb-wrapper float-start">
                        <ol class="breadcrumb mb-0">
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
            <form class="form" id="searchForm" method="GET" action="{{ route('ReportsPurchases.SuppliersDirectory') }}">
                <div class="row g-3">
                    <!-- فلترة حسب المدينة -->
                    <div class="col-md-3">
                        <label for="city" class="form-label"> المدينة </label>
                        <input type="text" name="city" class="form-control" value="{{ request('city') }}">
                    </div>

                    <!-- فلترة حسب البلد -->
                    <div class="col-md-3">
                        <label for="country" class="form-label">البلد </label>
                        <input type="text" name="country" class="form-control" value="{{ request('country') }}" placeholder="البلد">
                    </div>

                    <!-- فلترة حسب الفرع -->
                    <div class="col-md-3">
                        <label for="branch_id" class="form-label">الفرع </label>
                        <select name="branch_id" class="form-control">
                            <option value="">الفرع</option>
                            @foreach ($branches as $branch)
                                <option value="{{ $branch->id }}" {{ request('branch_id') == $branch->id ? 'selected' : '' }}>
                                    {{ $branch->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- فلترة حسب التجميع -->
                    <div class="col-md-3">
                        <label for="group_by"> تجميع حسب</label>
                        <select name="group_by" class="form-control">
                            <option value="">اختر</option>
                            <option value="supplier" {{ request('group_by') == 'supplier' ? 'selected' : '' }}>المورد</option>
                            <option value="branch" {{ request('group_by') == 'branch' ? 'selected' : '' }}>الفرع</option>
                        </select>
                    </div>
                </div>

                <!-- أزرار البحث والإلغاء -->
                <div class="form-actions mt-2">
                    <button type="submit" class="btn btn-primary">عرض التقرير</button>
                    <a href="{{ route('ReportsPurchases.SuppliersDirectory') }}" class="btn btn-outline-warning">إلغاء</a>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive" id="purchaseReportTable">
                <!-- أزرار التصدير -->
                <div class="mb-3">
                    <button type="button" class="btn btn-success" id="exportExcel">تصدير Excel</button>
                    <button type="button" class="btn btn-danger" onclick="exportToPDF()">تصدير PDF</button>
                </div>

                <!-- الجدول لعرض البيانات -->
                <table class="table table-bordered table-striped" id="suppliersTable">
                    <thead>
                        <tr>
                            <th>الكود</th>
                            <th>الاسم</th>
                            <th>العنوان</th>
                            <th>الهاتف</th>
                            <th>الجوال</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($suppliers as $supplier)
                        <tr>
                            <td>{{ $supplier->number_suply }}</td>
                            <td>{{ $supplier->trade_name }}</td>
                            <td>{{ $supplier->getFullAddressAttribute() }}</td>
                            <td>{{ $supplier->phone }}</td>
                            <td>{{ $supplier->mobile }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- مكتبات JavaScript للتصدير -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.24/jspdf.plugin.autotable.min.js"></script>
    <script>
        $('#exportExcel').on('click', function() {
            const table = document.getElementById('purchaseReportTable');
            const wb = XLSX.utils.table_to_book(table, { raw: true });
            const today = new Date();
            const fileName = `تقرير_المشتريات_${today.getFullYear()}-${today.getMonth() + 1}-${today.getDate()}.xlsx`;
            XLSX.writeFile(wb, fileName);
        });
    </script>
@endpush
