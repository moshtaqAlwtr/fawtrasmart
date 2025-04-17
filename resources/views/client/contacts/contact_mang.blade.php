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
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <!-- Checkbox لتحديد الكل -->
                    <div class="form-check me-3">.
                        <input class="form-check-input" type="checkbox" id="selectAll" onclick="toggleSelectAll()">

                    </div>

                    <div class="d-flex flex-wrap justify-content-between">
                        <a href="{{ route('clients.create') }}" class="btn btn-success btn-sm flex-fill me-1 mb-1">
                            <i class="fas fa-plus-circle me-1"></i> اضافة عميل جديد
                        </a>

                        <button class="btn btn-outline-primary btn-sm flex-fill mb-1">
                            <i class="fas fa-cloud-upload-alt me-1"></i>استيراد
                        </button>
                    </div>
                    <nav aria-label="Page navigation">
                        <ul class="pagination pagination-sm mb-0">
                            <!-- زر الانتقال إلى أول صفحة -->
                            @if ($clients->onFirstPage())
                                <li class="page-item disabled">
                                    <span class="page-link border-0 rounded-pill" aria-label="First">
                                        <i class="fas fa-angle-double-right"></i>
                                    </span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link border-0 rounded-pill" href="{{ $clients->url(1) }}"
                                        aria-label="First">
                                        <i class="fas fa-angle-double-right"></i>
                                    </a>
                                </li>
                            @endif

                            <!-- زر الانتقال إلى الصفحة السابقة -->
                            @if ($clients->onFirstPage())
                                <li class="page-item disabled">
                                    <span class="page-link border-0 rounded-pill" aria-label="Previous">
                                        <i class="fas fa-angle-right"></i>
                                    </span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link border-0 rounded-pill" href="{{ $clients->previousPageUrl() }}"
                                        aria-label="Previous">
                                        <i class="fas fa-angle-right"></i>
                                    </a>
                                </li>
                            @endif

                            <!-- عرض رقم الصفحة الحالية -->
                            <li class="page-item">
                                <span class="page-link border-0 bg-light rounded-pill px-3">
                                    صفحة {{ $clients->currentPage() }} من {{ $clients->lastPage() }}
                                </span>
                            </li>

                            <!-- زر الانتقال إلى الصفحة التالية -->
                            @if ($clients->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link border-0 rounded-pill" href="{{ $clients->nextPageUrl() }}"
                                        aria-label="Next">
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

                            <!-- زر الانتقال إلى آخر صفحة -->
                            @if ($clients->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link border-0 rounded-pill"
                                        href="{{ $clients->url($clients->lastPage()) }}" aria-label="Last">
                                        <i class="fas fa-angle-double-left"></i>
                                    </a>
                                </li>
                            @else
                                <li class="page-item disabled">
                                    <span class="page-link border-0 rounded-pill" aria-label="Last">
                                        <i class="fas fa-angle-double-left"></i>
                                    </span>
                                </li>
                            @endif
                        </ul>
                    </nav>

                    <!-- جزء التنقل بين الصفحات -->

                </div>
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
                            <input type="text" id="search" class="form-control" placeholder="ادخل الاسم أو الكود"
                                name="search">
                        </div>
                    </div>

                    <!-- البحث المتقدم -->
                    <div class="collapse" id="advancedSearchForm">
                        <div class="form-body row">
                            <div class="form-group col-md-12">
                                <label for="advanced_search">بحث متقدم (بالبريد الإلكتروني أو رقم الهاتف أو الجوال)</label>
                                <input type="text" id="advanced_search" class="form-control"
                                    placeholder="ادخل البريد الإلكتروني أو رقم الهاتف أو الجوال" name="advanced_search">
                            </div>
                        </div>
                    </div>

                    <!-- أزرار البحث -->
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary mr-1 waves-effect waves-light">بحث</button>
                        <a class="btn btn-outline-secondary ml-2 mr-2" data-toggle="collapse" href="#advancedSearchForm"
                            aria-expanded="false" aria-controls="advancedSearchForm">
                            <i class="bi bi-sliders"></i> بحث متقدم
                        </a>
                        <button type="reset" class="btn btn-outline-warning waves-effect waves-light">إلغاء</button>
                    </div>
                </form>
            </div>
            @if (isset($clients) && !empty($clients) && count($clients) > 0)
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th width="5%" class="text-center">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="select-all">
                                    </div>
                                </th>
                                <th width="20%">الكود</th>
                                <th width="25%">الاسم التجاري</th>
                                <th width="20%" class="text-center">الهاتف</th>
                                <th width="10%" class="text-center">الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($clients as $client)
                                <tr>
                                    <td class="text-center">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="{{ $client->id }}">
                                        </div>
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ $client->code }}</small>
                                    </td>
                                    <td>
                                        <h5 class="mb-0">{{ $client->trade_name }}</h5>
                                    </td>
                                    <td class="text-center">
                                        <strong class="text-primary">
                                            <i class="fas fa-phone me-2"></i>{{ $client->phone }}
                                        </strong>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <div class="dropdown">
                                                <button class="btn btn-sm bg-gradient-info fa fa-ellipsis-v"
                                                    type="button" id="dropdownMenuButton{{ $client->id }}"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                </button>

                                                <ul class="dropdown-menu dropdown-menu-end show"
                                                    aria-labelledby="dropdownMenuButton{{ $client->id }}"
                                                    style="position: fixed; top: 100px; right: 120px; z-index: 1050;">



                                                    <li>
                                                        <a class="dropdown-item"
                                                            href="{{ route('clients.show', $client->id) }}">
                                                            <i class="fa fa-eye me-2 text-success"></i>شاهد العميل
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-danger" role="alert">
                    <p class="mb-0">لا توجد عملاء</p>
                </div>
            @endif
        </div>
    </div>
    </div>
@endsection


@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const advancedSearchButton = document.querySelector('[data-toggle="collapse"]');
            const advancedSearchForm = document.getElementById('advancedSearchForm');

            advancedSearchButton.addEventListener('click', function() {

            });
        });
    </script>
@endsection
