@extends('master')

@section('title')
    أدارة قائمة جهات الاتصال
@stop

@section('head')
    <!-- تضمين ملفات Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
@endsection

@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-check-circle me-2"></i>
                <strong>{{ session('success') }}</strong>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">ادارة قائمة جهات الاتصال </h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="">الرئيسيه</a>
                            </li>
                            <li class="breadcrumb-item active">عرض
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="content-body">
        <div class="card shadow-lg border-0 rounded-lg mb-4">
            <div class="card-header bg-white py-3">
                <div class="row justify-content-between align-items-center mx-2">
                    <!-- القسم الأيسر: زر إضافة عميل -->
                    <div class="col-auto">
                        <a href="{{ route('clients.create') }}" class="btn btn-success px-4">
                            <i class="fas fa-plus-circle me-2"></i>
                            إضافة عميل
                        </a>
                    </div>
    
                    <!-- القسم الأوسط: التنقل بين الصفحات -->
                    <div class="col-auto">
                        <nav aria-label="Page navigation">
                            <ul class="pagination mb-0 pagination-sm">
                                <!-- زر الانتقال إلى الصفحة الأولى -->
                                <li class="page-item">
                                    <a class="page-link border-0 rounded-start" href="#" aria-label="First">
                                        <i class="fas fa-angle-double-right"></i>
                                    </a>
                                </li>
    
                                <!-- زر الانتقال إلى الصفحة السابقة -->
                                <li class="page-item">
                                    <a class="page-link border-0" href="#" aria-label="Previous">
                                        <i class="fas fa-angle-right"></i>
                                    </a>
                                </li>
    
                                <!-- عرض رقم الصفحة الحالية -->
                                <li class="page-item">
                                    <span class="page-link border-0 bg-light rounded-pill px-3">
                                        صفحة {{ $clients->currentPage() }} من {{ $clients->lastPage() }}
                                    </span>
                                </li>
    
                                <!-- زر الانتقال إلى الصفحة التالية -->
                                @if ($clients->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link border-0 rounded-pill" href="{{ $clients->nextPageUrl() }}" aria-label="Next">
                                            <i class="fas fa-angle-left"></i>
                                        </a>
                                    </li>
                                @else
                                    <li class="page-item disabled">
                                        <span class="page-link border-0 rounded-pill" aria-label="Next">
                                            <i class="fas fa-angle-left"></i>
                                        </span>
                                    </li>
                                @endif
    
                                <!-- زر الانتقال إلى الصفحة الأخيرة -->
                                <li class="page-item">
                                    <a class="page-link border-0 rounded-end" href="#" aria-label="Last">
                                        <i class="fas fa-angle-double-left"></i>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
    
                    <!-- القسم الأيمن: زر تصدير إلى Excel -->
                    {{-- <div class="col-auto">
                        <a href="" class="btn btn-primary px-4">
                            <i class="fas fa-file-excel me-2"></i>
                            تصدير إلى Excel
                        </a>
                    </div> --}}
                </div>
            </div>
    
            <!-- محتوى الجدول -->
            <div class="card-body">
                <!-- محتوى الجدول هنا -->
            </div>
        </div>
    </div>

        <div class="card">
            <div class="card-content">
               
    <div class="card-body">
        <form class="form" method="GET" action="{{ route('clients.contacts') }}">
            <!-- البحث الأساسي -->
            <div class="form-body row">
                <div class="form-group col-md-12">
                    <label for="search">بحث بالاسم أو الكود</label>
                    <input type="text" id="search" class="form-control" placeholder="ادخل الاسم أو الكود" name="search">
                </div>
            </div>

            <!-- البحث المتقدم -->
            <div class="collapse" id="advancedSearchForm">
                <div class="form-body row">
                    <div class="form-group col-md-12">
                        <label for="advanced_search">بحث متقدم (بالبريد الإلكتروني أو رقم الهاتف أو الجوال)</label>
                        <input type="text" id="advanced_search" class="form-control" placeholder="ادخل البريد الإلكتروني أو رقم الهاتف أو الجوال" name="advanced_search">
                    </div>
                </div>
            </div>

            <!-- أزرار البحث -->
            <div class="form-actions">
                <button type="submit" class="btn btn-primary mr-1 waves-effect waves-light">بحث</button>
                <a class="btn btn-outline-secondary ml-2 mr-2" data-toggle="collapse" href="#advancedSearchForm" aria-expanded="false" aria-controls="advancedSearchForm">
                    <i class="bi bi-sliders"></i> بحث متقدم
                </a>
                <button type="reset" class="btn btn-outline-warning waves-effect waves-light">إلغاء</button>
            </div>
        </form>
    </div>
    @if (@isset($clients) && !@empty($clients) && count($clients) > 0)
    @foreach ($clients as $client)
        <div class="card">
            <div class="card-body">
                <div class="card-body row align-items-center">
                    <div class="col-md-1 text-center">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="{{ $client->id }}">
                        </div>
                    </div>
                    <div class="col-md-3">

                        <small class="text-muted">{{ $client->code }}</small>

                    </div>
                    <div class="col-md-3">
                        <h5 class="mb-0">{{ $client->trade_name }}</h5>
                    </div>
                    <div class="col-md-3 text-center">
                        <strong class="text-primary">
                            <i class="fas fa-phone me-2"></i>{{ $client->phone }}
                        </strong>
                    </div>
                    <div class="col-md-2 text-end">
                        <div class="btn-group">
                            <div class="dropdown">
                                <button class="btn bg-gradient-info fa fa-ellipsis-v mr-1 mb-1" type="button"id="dropdownMenuButton303" data-toggle="dropdown" aria-haspopup="true"aria-expanded="false"></button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton303">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('clients.show_contant', $client->id) }}">
                                            <i class="fa fa-eye me-2 text-primary"></i>شاهد العميل
                                        </a>
                                    </li>

                                    <div class="dropdown-divider"></div>
                                    <form id="delete-client-{{ $client->id }}"
                                        action="{{ route('clients.destroy', $client->id) }}"
                                        method="POST"
                                        style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="dropdown-item text-danger delete-client"
                                            data-id="{{ $client->id }}"
                                            onclick="return confirm('هل أنت متأكد من حذف هذا العميل؟')">
                                            <i class="fas fa-trash me-2"></i>حذف
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@else
    <div class="alert alert-danger" role="alert">
        <p class="mb-0">
            لا توجد  عملاء
        </p>
    </div>
@endif
</div>
</div>
</div>
@endsection
                   

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const advancedSearchButton = document.querySelector('[data-toggle="collapse"]');
            const advancedSearchForm = document.getElementById('advancedSearchForm');

            advancedSearchButton.addEventListener('click', function () {
               
            });
        });
    </script>
@endsection



