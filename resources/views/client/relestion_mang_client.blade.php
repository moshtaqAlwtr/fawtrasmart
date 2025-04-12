@extends('layouts.blank')

@section('content')
<style>
    /* تحسينات التصميم */
    .client-item {
        transition: all 0.3s ease;
        cursor: pointer;
        border-left: 3px solid transparent;
    }

    .client-item:hover {
        background-color: #f5f7fa;
    }

    .client-item.selected {
        background-color: #e0f0ff;
        border-left: 3px solid #3f6ad8;
    }

    .notes-timeline {
        max-height: 450px;
        overflow-y: auto;
        padding-right: 5px;
    }

    .note-item {
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        margin-bottom: 15px;
        padding: 12px;
    }

    .clients-list {
        max-height: calc(100vh - 120px);
        overflow-y: auto;
    }

    .search-bar {
        position: sticky;
        top: 0;
        z-index: 1020;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }

    .note-content {
        background-color: #f8f9fa;
        border-radius: 6px;
        padding: 10px;
        margin-top: 5px;
    }

    .badge.bg-warning {
        color: #212529 !important;
    }

    .client-info-card {
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
</style>

<div class="container-fluid">
    <div class="row g-0">
        <!-- القائمة الجانبية للعملاء -->
        <div class="col-md-4 border-end vh-100 overflow-hidden">
            <div class="d-flex flex-column h-100">
                <!-- شريط البحث -->
                <div class="search-bar p-3 border-bottom bg-white">
                    <div class="d-flex gap-2 mb-2">
                        <button class="btn btn-light border" type="button">
                            <i class="fas fa-bars"></i>
                        </button>
                        <div class="input-group">
                            <input type="text" class="form-control border-end-0" id="searchInput"
                                placeholder="البحث عن عميل بالاسم او البريد او الكود او رقم الهاتف...">
                            <span class="input-group-text bg-white border-start-0">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                        </div>
                        <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#addCustomerModal">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>

                <!-- قائمة العملاء -->
                <div class="clients-list overflow-auto flex-grow-1" id="clientsList">
                    @foreach ($clients as $client)
                    <div class="client-item p-3 border-bottom" data-client-id="{{ $client->id }}" onclick="selectClient({{ $client->id }})">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="badge bg-success country-badge">
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
                            <div class="status-badge px-2 py-1 rounded
                          @if(optional($client->latestStatus)->status == 'مديون')
    bg-warning
@elseif(optional($client->latestStatus)->status == 'دائن')
    bg-danger
@elseif(optional($client->latestStatus)->status == 'مميز')
    bg-primary
@else
    bg-secondary
@endif text-white">
{{ optional($client->latestStatus)->status ?? 'غير محدد' }}
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
                    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3 border-0 shadow-sm">
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
                            <a href="#" id="editClientButton" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                            <!-- معلومات العميل -->
                        <div class="client-info-card mb-4">
                            <div class="card shadow-sm">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-2">
                                            <div class="d-flex align-items-center">
                                                <span class="text-muted me-2"><i class="fas fa-user"></i></span>
                                                <span class="fw-bold" id="clientName">--</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <div class="d-flex align-items-center">
                                                <span class="text-muted me-2"><i class="fas fa-phone"></i></span>
                                                <span id="clientPhone">--</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <div class="d-flex align-items-center">
                                                <span class="text-muted me-2"><i class="fas fa-map-marker-alt"></i></span>
                                                <span id="clientCity">--</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <div class="d-flex align-items-center">
                                                <span class="text-muted me-2"><i class="fas fa-hashtag"></i></span>
                                                <span id="clientCode">--</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tabs -->
                        <ul class="nav nav-tabs mt-4" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="details-tab" data-bs-toggle="tab" href="#details" role="tab">
                                    <i class="fas fa-clipboard-list me-1"></i>
                                    المتابعة
                                    <span id="notes-count-badge" class="badge bg-primary rounded-pill ms-1">{{ $ClientRelations->count() }}</span>
                                </a>
                            </li>
                        </ul>

                        <div class="tab-content mt-3">
                            <!-- تبويب المتابعة -->
                            <div class="tab-pane fade show active" id="details" role="tabpanel">
                                <!-- نموذج إضافة ملاحظة -->
                                <form id="clientNoteForm" action="{{ route('clients.addnotes') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="client_id" id="client_id">
                                    <div class="card shadow-sm mb-4">
                                        <div class="card-body">
                                            <h6 class="card-title mb-3">إضافة ملاحظة جديدة</h6>
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <select class="form-select" name="status" required>
                                                        <option value="">اختر الحالة</option>
                                                        <option value="مديون">مديون</option>
                                                        <option value="دائن">دائن</option>
                                                        <option value="مميز">مميز</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <select class="form-select" name="process" required>
                                                        <option value="">اختر الإجراء</option>
                                                        <option value="متابعة هاتفية">متابعة هاتفية</option>
                                                        <option value="تحصيل">تحصيل</option>
                                                        <option value="توصيل">توصيل</option>
                                                        <option value="حجز">حجز</option>
                                                    </select>
                                                </div>
                                                <div class="col-12">
                                                    <textarea class="form-control" name="description" rows="4"
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

                                <!-- سجل الملاحظات -->
                                <div class="notes-timeline" id="notesTimeline">
                                    @foreach ($ClientRelations as $ClientRelation)
                                    <div class="note-item">
    <div class="d-flex align-items-center text-muted small mb-1">
        <i class="far fa-clock me-1"></i> {{$ClientRelation->created_at}}
        <span class="mx-2">•</span>
        <i class="far fa-user me-1"></i> {{$ClientRelation->process}}
        <span class="mx-2">•</span>
        <i class="fas fa-info-circle me-1"></i>
        <span class="badge
            @if($ClientRelation->status == 'مميز') bg-primary
            @elseif($ClientRelation->status == 'مديون') bg-warning text-dark
            @elseif($ClientRelation->status == 'دائن') bg-danger
            @else bg-secondary @endif">
            {{$ClientRelation->status}}
        </span>
    </div>
                                        <div class="note-content">
        <i class="far fa-comment-dots text-muted me-1"></i> {{$ClientRelation->description}}
    </div>
</div>
                                    @endforeach
                                </div>
                            </div>
                                </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

<!-- Modal إضافة عميل جديد -->
<div class="modal fade" id="addCustomerModal" tabindex="-1" aria-labelledby="addCustomerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCustomerModalLabel">إضافة عميل جديد</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="إغلاق">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addClientForm" action="{{ route('clients.mang_client_store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                <div class="modal-body">
                                    <div class="row">
                        <!-- ... (محتوى النموذج نفسه) ... -->
                                                    </div>
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
                    <button type="submit" class="btn btn-primary">حفظ</button>
            </div>
        </form>
        </div>
    </div>
</div>

<!-- تضمين JavaScript -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<script>
// متغيرات عامة
let clientsList = [];
let currentClientId = null;

// تهيئة الصفحة وتحميل البيانات
document.addEventListener("DOMContentLoaded", function() {
    // جلب قائمة العملاء
    fetch('/clients/clients_management/clients/all')
        .then(response => {
            if (!response.ok) {
                throw new Error('فشل في جلب قائمة العملاء');
            }
            return response.json();
        })
        .then(data => {
            clientsList = data;
            if (clientsList.length > 0) {
                // تحديد العميل الأول تلقائياً
                selectClient(clientsList[0].id);
            }
            updateNavigationButtons();
        })
        .catch(error => {
            console.error("خطأ:", error);
            toastr.error("حدث خطأ أثناء جلب قائمة العملاء");
        });

    // إعداد البحث
    document.getElementById("searchInput").addEventListener("input", function() {
        const searchValue = this.value.trim();
        if (searchValue.length > 0) {
            searchClients(searchValue);
        } else {
            displayAllClients();
        }
    });

    // إعداد نموذج الملاحظات
    document.getElementById("clientNoteForm").addEventListener("submit", function(e) {
        if (!currentClientId) {
            e.preventDefault();
            toastr.warning("الرجاء تحديد عميل أولاً");
        }
    });
});

// تحديد عميل
function selectClient(clientId) {
    currentClientId = clientId;

    // حفظ معرف العميل في النموذج
    document.getElementById("client_id").value = clientId;

    // تحديث تصميم العنصر المحدد في القائمة
    document.querySelectorAll(".client-item").forEach(item => {
        item.classList.remove("selected");
    });

    const selectedItem = document.querySelector(`[data-client-id="${clientId}"]`);
    if (selectedItem) {
        selectedItem.classList.add("selected");
        // تمرير إلى العنصر المحدد
        selectedItem.scrollIntoView({ behavior: "smooth", block: "nearest" });
    }

    // تفعيل زر التعديل
    document.getElementById("editClientButton").classList.remove("disabled");

    // جلب تفاصيل العميل
    fetch(`/clients/clients_management/clients/${clientId}`)
        .then(response => response.json())
        .then(client => {
            // تحديث واجهة المستخدم ببيانات العميل
            document.getElementById("clientName").textContent = client.trade_name || "غير محدد";
            document.getElementById("clientPhone").textContent = client.phone || client.mobile || "غير محدد";
            document.getElementById("clientCity").textContent = client.city ? `${client.city}, ${client.region || ''}` : "غير محدد";
            document.getElementById("clientCode").textContent = client.code || "غير محدد";
        })
        .catch(error => {
            console.error("خطأ:", error);
            toastr.error("حدث خطأ أثناء جلب تفاصيل العميل");
        });

    // جلب ملاحظات العميل
    fetch(`/clients/clients_management/clients/${clientId}/notes`)
        .then(response => response.json())
        .then(data => {
            let notesContainer = document.getElementById("notesTimeline");
            let notesCountBadge = document.getElementById("notes-count-badge");
            notesContainer.innerHTML = "";

            if (data.message) {
                notesContainer.innerHTML = `<p class="text-center text-muted py-3">${data.message}</p>`;
                notesCountBadge.textContent = "0";
            } else {
                notesCountBadge.textContent = data.length;

                data.forEach(note => {
                    // تنسيق التاريخ
                    const formattedDate = new Date(note.created_at).toLocaleString("ar-EG");

                    // تحديد لون الحالة
                    let statusClass = "bg-secondary";
                    if (note.status === "مميز") statusClass = "bg-primary";
                    else if (note.status === "مديون") statusClass = "bg-warning text-dark";
                    else if (note.status === "دائن") statusClass = "bg-danger";

                    notesContainer.innerHTML += `
                        <div class="note-item">
                            <div class="d-flex align-items-center text-muted small mb-1">
                                <i class="far fa-calendar-alt me-1 text-primary"></i> ${formattedDate}
                                <span class="mx-2">•</span>
                                <i class="fas fa-bell me-1 text-info"></i> ${note.process}
                                <span class="mx-2">•</span>
                                <i class="fas fa-info-circle me-1"></i>
                                <span class="badge ${statusClass}">${note.status}</span>
                            </div>
                            <div class="note-content">
                                <i class="far fa-comment-dots text-muted me-1"></i> ${note.description}
                            </div>
                        </div>
                    `;
                });
            }

            // تحديث أزرار التنقل بعد اختيار العميل
            updateNavigationButtons();
        })
        .catch(error => {
            console.error("خطأ:", error);
            toastr.error("حدث خطأ أثناء جلب ملاحظات العميل");
        });
}

// البحث عن العملاء
function searchClients(searchValue) {
        fetch(`/clients/clients_management/clients/search?query=${encodeURIComponent(searchValue)}`)
            .then(response => response.json())
            .then(data => {
            updateClientsList(data);
            })
            .catch(error => {
            console.error("خطأ:", error);
            toastr.error("حدث خطأ أثناء البحث");
            });
    }

// عرض جميع العملاء
function displayAllClients() {
    updateClientsList(clientsList);
}

// تحديث قائمة العملاء في واجهة المستخدم
function updateClientsList(clients) {
    const clientsListContainer = document.getElementById("clientsList");
            clientsListContainer.innerHTML = "";

    if (clients.length === 0) {
        clientsListContainer.innerHTML = `<p class="text-center text-muted py-3">لا توجد نتائج</p>`;
        return;
    }

    clients.forEach(client => {
                let status = client.latest_status ? client.latest_status.status : 'غير محدد';
                let statusColor = getStatusColor(status);

        const clientCreatedDate = new Date(client.created_at);
        const formattedTime = clientCreatedDate.toLocaleTimeString("ar-EG", { hour: '2-digit', minute: '2-digit' });
        const formattedDate = clientCreatedDate.toLocaleDateString("ar-EG", { year: 'numeric', month: 'short', day: 'numeric' });

                clientsListContainer.innerHTML += `
            <div class="client-item p-3 border-bottom" data-client-id="${client.id}" onclick="selectClient(${client.id})">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="badge bg-success country-badge">
                                        ${client.country_code || 'SA'}
                                    </span>
                                    <span class="client-number text-muted">#${client.code}</span>
                                    <span class="client-name text-primary fw-medium">${client.trade_name}</span>
                                </div>
                                <div class="client-info small text-muted mt-1">
                                    <i class="far fa-clock me-1"></i>
                            ${formattedTime} | ${formattedDate}
                                </div>
                                ${client.phone ? `
                                <div class="client-contact small text-muted mt-1">
                                    <i class="fas fa-phone-alt me-1"></i>
                                    ${client.phone}
                                </div>
                                ` : ''}
                            </div>
                            <div class="status-badge px-2 py-1 rounded ${statusColor} text-white">
                                ${status}
                            </div>
                        </div>
                    </div>
                `;
    });
}

// تحميل العميل التالي
function loadNextClient() {
    const currentIndex = clientsList.findIndex(client => client.id == currentClientId);
    if (currentIndex < clientsList.length - 1) {
        selectClient(clientsList[currentIndex + 1].id);
    } else {
        toastr.info("لا يوجد المزيد من العملاء");
    }
}

// تحميل العميل السابق
function loadPreviousClient() {
    const currentIndex = clientsList.findIndex(client => client.id == currentClientId);
    if (currentIndex > 0) {
        selectClient(clientsList[currentIndex - 1].id);
    } else {
        toastr.info("أنت في بداية قائمة العملاء");
    }
}

// تحديث حالة أزرار التنقل
function updateNavigationButtons() {
    const currentIndex = clientsList.findIndex(client => client.id == currentClientId);
    const prevButton = document.getElementById("prevButton");
    const nextButton = document.getElementById("nextButton");

    if (prevButton) {
        prevButton.disabled = currentIndex <= 0;
    }

    if (nextButton) {
        nextButton.disabled = currentIndex >= clientsList.length - 1 || currentIndex === -1;
    }
}

// طباعة تفاصيل العميل
function printClientDetails() {
    if (!currentClientId) {
        toastr.warning("الرجاء تحديد عميل أولاً");
        return;
    }

    const printWindow = window.open('', '_blank');

    if (!printWindow) {
        toastr.error("تم منع فتح نافذة الطباعة. يرجى السماح بالنوافذ المنبثقة.");
        return;
    }

    const client = clientsList.find(c => c.id == currentClientId);
    if (!client) return;

    const clientName = document.getElementById("clientName").textContent;
    const clientPhone = document.getElementById("clientPhone").textContent;
    const clientCity = document.getElementById("clientCity").textContent;
    const clientCode = document.getElementById("clientCode").textContent;
    const notesHTML = document.getElementById("notesTimeline").innerHTML;

    printWindow.document.write(`
        <!DOCTYPE html>
        <html dir="rtl">
        <head>
            <title>تفاصيل العميل: ${clientName}</title>
            <meta charset="UTF-8">
            <style>
                body { font-family: Arial, sans-serif; padding: 20px; }
                .header { text-align: center; margin-bottom: 20px; }
                .client-info { margin-bottom: 20px; }
                .client-info div { margin-bottom: 5px; }
                .notes-title { margin: 20px 0 10px; border-bottom: 1px solid #ddd; padding-bottom: 5px; }
                .note-item { margin-bottom: 15px; padding: 10px; border: 1px solid #eee; border-radius: 5px; }
                .note-meta { color: #666; font-size: 0.9em; margin-bottom: 5px; }
                .badge { display: inline-block; padding: 3px 6px; border-radius: 3px; font-size: 0.8em; }
                .bg-primary { background-color: #007bff; color: white; }
                .bg-warning { background-color: #ffc107; color: black; }
                .bg-danger { background-color: #dc3545; color: white; }
                .bg-secondary { background-color: #6c757d; color: white; }
            </style>
        </head>
        <body>
            <div class="header">
                <h1>تفاصيل العميل</h1>
                <p>تاريخ الطباعة: ${new Date().toLocaleString("ar-EG")}</p>
                </div>

            <div class="client-info">
                <h2>${clientName}</h2>
                <div><strong>رقم الكود:</strong> ${clientCode}</div>
                <div><strong>رقم الهاتف:</strong> ${clientPhone}</div>
                <div><strong>العنوان:</strong> ${clientCity}</div>
                </div>

            <h3 class="notes-title">سجل المتابعة</h3>
            <div class="notes-list">
                ${notesHTML}
            </div>
        </body>
        </html>
    `);

    printWindow.document.close();
    printWindow.focus();
    setTimeout(function() { printWindow.print(); }, 500);
}

// دالة لتحديد لون الحالة بناءً على القيمة
function getStatusColor(status) {
    switch (status) {
        case 'مديون':
            return 'bg-warning';
        case 'دائن':
            return 'bg-danger';
        case 'مميز':
            return 'bg-primary';
        default:
            return 'bg-secondary';
    }
}
</script>
@endsection


