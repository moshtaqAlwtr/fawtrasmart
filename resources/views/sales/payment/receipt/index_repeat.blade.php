@extends('master')

@section('title')
    ايصال
@stop

<div aria-live="polite" aria-atomic="true" class="position-fixed top-0 end-0 p-3" style="z-index: 1050;">
    <!-- Toast -->
    @if (session('message'))
        <div class="toast align-items-center text-bg-danger border-0 show" role="alert" aria-live="assertive"
            aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ session('message') }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
        </div>
    @endif
</div>
@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">ادارة ايصالات الدفع </h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="">الرئيسية</a>
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

        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center flex-wrap">

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="d-flex gap-2">



                            <a href="#" class="btn btn-sm btn-outline-success d-inline-flex align-items-center">
                                <i class="far fa-sticky-note me-1"></i> طباعة
                            </a>
                            <a href="#" class="btn btn-sm btn-outline-info d-inline-flex align-items-center">
                                <i class="fas fa-file-invoice me-1"></i> PDF
                            </a>
                            <a href="#" class="btn btn-sm btn-outline-primary d-inline-flex align-items-center">
                                <i class="far fa-file-alt me-1"></i> ارسال بريد
                            </a>



                        </div>

                    </div>
                </div>

                <div class="tab-content">
                    <div class="tab-pane fade show active d-flex justify-content-center align-items-center" id="quote"
                        role="tabpanel" aria-labelledby="quote-tab" style="height: 100%;">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="tab-pane fade show active"
                                    style="background: lightslategray; min-height: 100vh; padding: 20px;">
                                    <div class="card shadow" style="max-width: 600px; margin: 20px auto;">
                                        <div class="card-body bg-white p-4" style="min-height: 400px; overflow: auto;">
                                            <div style="transform: scale(0.8); transform-origin: top center;">
                                                @include('sales.payment.receipt.pdf_receipt', [
                                                    'receipt' => $receipt,
                                                ])
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var toastElList = [].slice.call(document.querySelectorAll('.toast'));
            toastElList.map(function(toastEl) {
                return new bootstrap.Toast(toastEl).show();
            });
        });
    </script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{ asset('assets/js/applmintion.js') }}"></script>
@endsection
