@extends('layouts.blank')

@section('content')
<div class="container-fluid">
    <div class="row g-0">
        <!-- القائمة الجانبية للعملاء -->
        <div class="col-md-4 border-end vh-100 overflow-hidden">
            <div class="d-flex flex-column h-100">
                <!-- شريط البحث -->
                <div class="search-bar p-3 border-bottom bg-white sticky-top">
                    <div class="d-flex gap-2 mb-2">
                        <button class="btn btn-light border" type="button">
                            <i class="fas fa-bars"></i>
                        </button>
                        <div class="input-group">
                            <input type="text" class="form-control border-end-0" id="searchInput"
                                placeholder="البحث عن عميل...">
                            <span class="input-group-text bg-white border-start-0">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                            <button class="btn btn-outline-secondary" type="button" data-bs-toggle="collapse"
                                data-bs-target="#advancedSearch" aria-expanded="false">
                                <i class="fas fa-filter"></i>
                            </button>
                        </div>
                        <button class="btn btn-primary" type="button">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>

                    <!-- Advanced Search Options -->
                    <div class="collapse" id="advancedSearch">
                        <div class="card card-body p-3 border-0">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="checkMerf">
                                        <label class="form-check-label" for="checkMerf">المعرف</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="checkStatus">
                                        <label class="form-check-label" for="checkStatus">الحالة</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="checkCountry">
                                        <label class="form-check-label" for="checkCountry">رمز البلد</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="checkEmail">
                                        <label class="form-check-label" for="checkEmail">البريد الإلكتروني</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="checkPhone">
                                        <label class="form-check-label" for="checkPhone">رقم الهاتف</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="checkCode">
                                        <label class="form-check-label" for="checkCode">كود العميل</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="checkLink">
                                        <label class="form-check-label" for="checkLink">الرابط</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="checkTradeName">
                                        <label class="form-check-label" for="checkTradeName">الاسم التجاري</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="checkClientStatus">
                                        <label class="form-check-label" for="checkClientStatus">حالات متابعة العميل</label>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3">
                                <div class="d-flex justify-content-between">
                                    <button class="btn btn-sm btn-primary" type="button">بحث</button>
                                    <button class="btn btn-sm btn-secondary" type="button">إعادة البحث</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- قائمة العملاء -->
                <div class="clients-list overflow-auto flex-grow-1">
                    @foreach ($clients as $client)
                    <div class="client-item p-3 border-bottom hover-bg-light cursor-pointer"
                         data-client-id="{{ $client->id }}"
                         onclick="loadClientDetails({{ $client->id }})">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="badge bg-{{ $client->status == 'active' ? 'success' : 'warning' }} country-badge">
                                        {{ $client->country_code ?? 'SA' }}
                                    </span>
                                    <span class="client-number text-muted">#{{ $client->code }}</span>
                                    <span class="client-name text-primary fw-medium">{{ $client->trade_name }}</span>
                                </div>
                                <div class="client-info small text-muted mt-1">
                                    <i class="far fa-clock me-1"></i>
                                    {{ $client->created_at->format('H:i') }} |
                                    {{ $client->created_at->format('M d,Y') }}
                                </div>
                                @if($client->phone)
                                <div class="client-contact small text-muted mt-1">
                                    <i class="fas fa-phone-alt me-1"></i>
                                    {{ $client->phone }}
                                </div>
                                @endif
                            </div>
                            <div class="status-badge px-2 py-1 rounded {{ $client->status == 'active' ? 'bg-success' : 'bg-warning' }} text-white">
                                {{ $client->status == 'active' ? 'نشط' : 'معلق' }}
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- تفاصيل العميل -->
        <div class="col-md-8 bg-light">
            <div class="client-details h-100">
                <div class="card border-0 h-100">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3 border-0">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-outline-primary btn-sm" id="prevButton" onclick="loadPreviousClient()">
                                <i class="fas fa-chevron-right"></i> السابق
                            </button>
                            <button type="button" class="btn btn-outline-primary btn-sm" id="nextButton" onclick="loadNextClient()">
                                التالي <i class="fas fa-chevron-left"></i>
                            </button>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="printClientDetails()">
                                <i class="fas fa-print"></i>
                            </button>
                            <button type="button" class="btn btn-outline-primary btn-sm" onclick="editClient()">
                                <i class="fas fa-edit"></i>
                            </button>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row g-3">
                            <!-- معلومات العميل -->



                        </div>

                        <!-- Tabs -->
                        <ul class="nav nav-tabs mt-4" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="details-tab" data-bs-toggle="tab" href="#details" role="tab">
                                    <i class="fas fa-clipboard-list me-1"></i>
                                    المتابعة
                                    <span class="badge bg-primary rounded-pill ms-1">{{ $notes->count() }}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="balance-tab" data-bs-toggle="tab" href="#balance" role="tab">
                                    <i class="fas fa-wallet me-1"></i>
                                    النقاط والأرصدة
                                </a>
                            </li>
                        </ul>

                        <div class="tab-content mt-3">
                            <!-- تبويب المتابعة -->
                            <div class="tab-pane fade show active" id="details" role="tabpanel">
                                <div class="notes-timeline">
                                    @foreach($notes as $note)
                                    <div class="note-item mb-3">
                                        <div class="d-flex align-items-center text-muted small mb-1">
                                            <i class="far fa-clock me-1"></i>
                                            {{ $note->created_at->diffForHumans() }}
                                            <span class="mx-2">•</span>
                                            <i class="far fa-user me-1"></i>
                                            {{ $note->user->name }}
                                        </div>
                                        <div class="note-content p-3 bg-white rounded shadow-sm">
                                            {!! $note->content !!}
                                        </div>
                                    </div>
                                    @endforeach
                                </div>

                                <!-- نموذج إضافة ملاحظة -->
                                <form id="addNoteForm" class="mt-4">
                                    <div class="card shadow-sm">
                                        <div class="card-body">
                                            <h6 class="card-title mb-3">إضافة ملاحظة جديدة</h6>
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <select class="form-select" name="status" required>
                                                        <option value="">اختر الحالة</option>
                                                        <option value="active">نشط</option>
                                                        <option value="inactive">غير نشط</option>
                                                        <option value="pending">معلق</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <select class="form-select" name="action" required>
                                                        <option value="">اختر الإجراء</option>
                                                        <option value="follow_up">متابعة</option>
                                                        <option value="visit">زيارة</option>
                                                        <option value="call">اتصال</option>
                                                    </select>
                                                </div>
                                                <div class="col-12">
                                                    <textarea class="form-control" name="content" rows="4"
                                                              placeholder="اكتب ملاحظتك هنا..." required></textarea>
                                                </div>
                                                <div class="col-12 text-end">
                                                    <button type="submit" class="btn btn-primary">
                                                        <i class="fas fa-save me-1"></i>
                                                        حفظ الملاحظة
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <!-- تبويب النقاط والأرصدة -->
                            <div class="tab-pane fade" id="balance" role="tabpanel">
                                <div class="text-end mb-3">
                                    <button type="button" class="btn btn-primary btn-sm">
                                        <i class="fas fa-plus me-1"></i>
                                        إضافة رصيد
                                    </button>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="text-center py-5 text-muted">
                                            <i class="fas fa-wallet fa-3x mb-3"></i>
                                            <p>لا توجد أرصدة مضافة حتى الآن</p>
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


    <script>
        let currentClientId = null;

        function loadPreviousClient() {
            const clientItems = Array.from(document.querySelectorAll('.client-item'));
            const currentIndex = clientItems.findIndex(item => item.dataset.clientId == currentClientId);

            if (currentIndex > 0) {
                const prevClientId = clientItems[currentIndex - 1].dataset.clientId;
                loadClientDetails(prevClientId);
            }
        }

        function loadNextClient() {
            const clientItems = Array.from(document.querySelectorAll('.client-item'));
            const currentIndex = clientItems.findIndex(item => item.dataset.clientId == currentClientId);

            if (currentIndex < clientItems.length - 1) {
                const nextClientId = clientItems[currentIndex + 1].dataset.clientId;
                loadClientDetails(nextClientId);
            }
        }

        function updateNavigationButtons() {
            const clientItems = Array.from(document.querySelectorAll('.client-item'));
            const currentIndex = clientItems.findIndex(item => item.dataset.clientId == currentClientId);

            const prevButton = document.getElementById('prevButton');
            const nextButton = document.getElementById('nextButton');

            if (prevButton) {
                prevButton.disabled = currentIndex <= 0;
            }

            if (nextButton) {
                nextButton.disabled = currentIndex >= clientItems.length - 1;
            }
        }

        // Load initial client data when page loads
        document.addEventListener('DOMContentLoaded', function() {
            const firstClient = document.querySelector('.client-item');
            if (firstClient) {
                const clientId = firstClient.dataset.clientId;
                loadClientDetails(clientId);
            }

            // If we have a client ID in the URL, load that client
            const urlParts = window.location.pathname.split('/');
            const clientIdFromUrl = urlParts[urlParts.length - 1];
            if (clientIdFromUrl && !isNaN(clientIdFromUrl)) {
                loadClientDetails(clientIdFromUrl);
            }
        });
    </script>
    <script src="{{ asset('assets/js/applmintion.js') }}"></script>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

@endsection
