@extends('master')

@section('title', 'إضافة ملاحظة أو مرفق')

@section('content')
    <div class="container mt-4">
<<<<<<< HEAD
        <form onsubmit="return validateForm()" id="clientForm" action="{{ route('clients.addnotes') }}" method="POST"
            enctype="multipart/form-data">
=======
        <form onsubmit="return validateAttachments()" id="clientForm" action="{{ route('clients.addnotes') }}" method="POST" enctype="multipart/form-data">
>>>>>>> 0865896ea3505cae60f0943c61cae726cbc1a34e
            @csrf
            <input type="hidden" name="current_latitude" id="current_latitude">
            <input type="hidden" name="current_longitude" id="current_longitude">

            <!-- رسائل الأخطاء والنجاح -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    {{ session('error') }}
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                </div>
            @endif

            <!-- شريط الأزرار العلوي -->
            <div class="card mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <div>
                            <h5 class="mb-1">إضافة ملاحظة أو مرفق</h5>
                            <small class="text-muted">الحقول التي عليها علامة <span class="text-danger">*</span> إلزامية</small>
                        </div>
                        <div>
                            <a href="{{ route('appointments.index') }}" class="btn btn-outline-danger me-2">
                                <i class="fas fa-times me-1"></i>إلغاء
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i>حفظ
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- مودال تعديل الإجراءات -->
            <div class="modal fade" id="proceduresModal" tabindex="-1" aria-labelledby="proceduresModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title" id="proceduresModalLabel">
                                <i class="fas fa-cogs me-2"></i>تعديل قائمة الإجراءات
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                يمكنك إضافة حتى 6 إجراءات مخصصة. الإجراءات المضافة ستظهر في جميع النماذج.
                            </div>

                            <div id="procedures-list" class="mb-4">
                                <!-- القائمة ستضاف هنا -->
                            </div>

<<<<<<< HEAD
                            <div class="border-top pt-3">
                                <h6 class="fw-bold mb-3">إضافة إجراء جديد:</h6>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="newProcedureName"
                                        placeholder="اسم الإجراء الجديد" maxlength="50">
                                    <button class="btn btn-success" type="button" id="addProcedureBtn">
                                        <i class="fas fa-plus me-1"></i>إضافة
                                    </button>
=======
                    </div>

                    <!-- New Fields -->
                    <div class="row mb-3">
                        <!-- عدد العهدة -->
                        <div class="form-group col-md-4">
                            <label for="deposit_count" class="form-label">عدد العهدة الموجودة</label>
                            <input type="number" class="form-control" id="deposit_count" name="deposit_count" min="0" required>
                        </div>

                        <!-- نوع الموقع -->
                        <div class="form-group col-md-4">
                            <label for="site_type" class="form-label">نوع الموقع</label>
                            <select class="form-control" id="site_type" name="site_type" required>
                                <option value="">اختر نوع الموقع</option>
                                <option value="independent_booth">بسطة مستقلة</option>
                                <option value="grocery">بقالة</option>
                                <option value="supplies">تموينات</option>
                                <option value="markets">أسواق</option>
                                <option value="station">محطة</option>
                            </select>
                        </div>

                        <!-- عدد استندات المنافسين -->
                        <div class="form-group col-md-4">
                            <label for="competitor_documents" class="form-label">عدد استندات المنافسين</label>
                            <input type="number" class="form-control" id="competitor_documents" name="competitor_documents" min="0" required>
                        </div>
                    </div>

                    <!-- Notes -->
                    <div class="mb-3">
                        <label for="notes" class="form-label">ملاحظة</label>
                        <textarea class="form-control" name="description" rows="4" required></textarea>
                    </div>

                    <!-- Attachments -->
                    <div class="col-md-12 col-12 mb-3">
                        <div class="form-group">
                            <label for="attachments" class="form-label">المرفقات</label>
                            <input type="file" name="attachments[]" multiple id="attachments" class="form-control d-none"
                                onchange="previewSelectedFiles()" required>
                            <div class="upload-area border rounded p-4 text-center position-relative bg-light"
                                onclick="document.getElementById('attachments').click()" style="cursor: pointer;">
                                <div class="d-flex flex-column align-items-center justify-content-center gap-2">
                                    <i class="fas fa-cloud-upload-alt fa-2x text-primary"></i>
                                    <p class="mb-0 text-primary fw-bold">اضغط هنا أو اختر من جهازك</p>
                                    <small class="text-muted">يمكنك رفع صور، فيديوهات، وملفات PDF/Word/Excel</small>
>>>>>>> 0865896ea3505cae60f0943c61cae726cbc1a34e
                                </div>
                                <small class="text-muted">الحد الأقصى 50 حرف</small>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                <i class="fas fa-times me-1"></i>إلغاء
                            </button>
                            <button type="button" class="btn btn-success" id="saveProcedures">
                                <i class="fas fa-check me-1"></i>حفظ التغييرات
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- النموذج الرئيسي -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-light">
                    <h6 class="mb-0 text-primary">
                        <i class="fas fa-edit me-2"></i>بيانات الملاحظة
                    </h6>
                </div>
                <div class="card-body">
                    <input type="hidden" name="client_id" value="{{ $id }}">

                    <!-- الصف الأول -->
                    <div class="row mb-4">
                        <!-- عدد العهدة -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="deposit_count" class="form-label fw-bold">
                                    <i class="fas fa-box text-primary me-1"></i>عدد العهدة الموجودة <span class="text-danger">*</span>
                                </label>
                                <input type="number" class="form-control form-control-lg" id="deposit_count"
                                    name="deposit_count" min="0" value="{{ old('deposit_count') }}" required
                                    placeholder="أدخل العدد">
                                <small class="text-muted">العدد الحالي للعهدة المتاحة</small>
                            </div>
                        </div>

                        <!-- نوع الإجراء -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="action_type" class="form-label fw-bold">
                                    <i class="fas fa-tasks text-success me-1"></i>نوع الإجراء <span class="text-danger">*</span>
                                </label>
                                <select class="form-control form-control-lg" id="action_type" name="process" required>
                                    <option value="">اختر نوع الإجراء</option>
                                </select>
                                <small class="text-muted">حدد نوع الإجراء المطلوب تنفيذه</small>
                            </div>
                        </div>

                        <!-- عدد مستندات المنافسين -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="competitor_documents" class="form-label fw-bold">
                                    <i class="fas fa-file-alt text-warning me-1"></i>عدد مستندات المنافسين <span class="text-danger">*</span>
                                </label>
                                <input type="number" class="form-control form-control-lg" id="competitor_documents"
                                    name="competitor_documents" min="0" value="{{ old('competitor_documents') }}" required
                                    placeholder="أدخل العدد">
                                <small class="text-muted">عدد المستندات المتوفرة للمنافسين</small>
                            </div>
                        </div>
                    </div>

                    <!-- تنبيه المتابعة (يظهر عند اختيار المتابعة) -->
                    <div id="followUpAlert" class="alert alert-warning d-none" role="alert">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-bell fa-2x text-warning me-3"></i>
                            <div>
                                <h6 class="alert-heading mb-1">تنبيه متابعة!</h6>
                                <p class="mb-0">عند اختيار "متابعة" سيتم إنشاء تذكير لك لمراجعة هذا العميل لاحقاً.</p>
                                @if(auth()->user()->role === 'manager')
                                    <small class="text-muted">سيتم تغيير حالة العميل إلى "متابعة"</small>
                                @else
                                    <small class="text-muted">ستبقى حالة العميل "نشط" مع إضافة تذكير متابعة</small>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- الملاحظة -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="description" class="form-label fw-bold">
                                    <i class="fas fa-sticky-note text-info me-1"></i>الملاحظة <span class="text-danger">*</span>
                                </label>
                                <textarea class="form-control" name="description" id="description" rows="4"
                                    required placeholder="اكتب ملاحظتك هنا...">{{ old('description') }}</textarea>
                                <div class="d-flex justify-content-between mt-1">
                                    <small class="text-muted">اكتب تفاصيل الملاحظة أو الإجراء المتخذ</small>
                                    <small class="text-muted" id="charCount">0 حرف</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- المرفقات -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="attachments" class="form-label fw-bold">
                                    <i class="fas fa-paperclip text-secondary me-1"></i>المرفقات <span class="text-danger">*</span>
                                </label>
                                <input type="file" name="attachments[]" multiple id="attachments"
                                    class="form-control d-none" onchange="previewSelectedFiles()" accept=".jpg,.jpeg,.png,.pdf,.doc,.docx,.xlsx,.txt,.mp4,.webm,.ogg" required>

                                <div class="upload-area border-2 border-dashed rounded p-4 text-center position-relative bg-light hover-shadow"
                                    onclick="document.getElementById('attachments').click()" style="cursor: pointer; transition: all 0.3s;">
                                    <div class="d-flex flex-column align-items-center justify-content-center gap-3">
                                        <div class="upload-icon">
                                            <i class="fas fa-cloud-upload-alt fa-3x text-primary"></i>
                                        </div>
                                        <div>
                                            <h6 class="text-primary fw-bold mb-1">اضغط هنا لاختيار الملفات</h6>
                                            <p class="text-muted mb-0">أو اسحب الملفات وأفلتها هنا</p>
                                        </div>
                                        <small class="text-muted">
                                            الأنواع المدعومة: JPG, PNG, PDF, DOC, DOCX, XLSX, TXT, MP4, WEBM, OGG
                                            <br>الحد الأقصى: 100 ميجابايت لكل ملف
                                        </small>
                                    </div>
                                </div>

                                <!-- معاينة الملفات المختارة -->
                                <div id="selected-files" class="mt-3"></div>
                            </div>
                        </div>
                    </div>

                    <!-- الخيارات الإضافية -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card border-0 bg-light">
                                <div class="card-body py-3">
                                    <h6 class="card-title mb-3">
                                        <i class="fas fa-cog me-2"></i>خيارات إضافية
                                    </h6>
                                    <div class="form-check form-check-lg">
                                        <input class="form-check-input" type="checkbox" name="share_with_work"
                                            id="shareWithWork" {{ old('share_with_work') ? 'checked' : '' }}>
                                        <label class="form-check-label fw-bold" for="shareWithWork">
                                            <i class="fas fa-share-alt text-primary me-1"></i>
                                            مشاركة مع فريق العمل
                                        </label>
                                        <small class="d-block text-muted mt-1">سيتم إشعار جميع أعضاء الفريق بهذه الملاحظة</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- تذييل البطاقة -->
                <div class="card-footer bg-light">
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                            <i class="fas fa-info-circle me-1"></i>
                            جميع البيانات المدخلة سيتم حفظها وربطها بالعميل المحدد
                        </small>
                        <div>
                            <button type="reset" class="btn btn-outline-secondary me-2">
                                <i class="fas fa-undo me-1"></i>إعادة تعيين
                            </button>
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save me-1"></i>حفظ الملاحظة
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- مودال تأكيد المتابعة -->
    <div class="modal fade" id="followUpConfirmModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title">
                        <i class="fas fa-bell me-2"></i>تأكيد المتابعة
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-3">
                        <i class="fas fa-question-circle fa-3x text-warning"></i>
                    </div>
                    <h6 class="text-center">هل أنت متأكد من إضافة متابعة لهذا العميل؟</h6>
                    <p class="text-center text-muted mb-0">سيتم إنشاء تذكير لك لمراجعته لاحقاً</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>إلغاء
                    </button>
                    <button type="button" class="btn btn-warning" id="confirmFollowUp">
                        <i class="fas fa-check me-1"></i>تأكيد المتابعة
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <style>
        .hover-shadow:hover {
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            border-color: #007bff !important;
        }

        .upload-area:hover .upload-icon i {
            transform: scale(1.1);
            transition: transform 0.3s;
        }

        .form-control-lg {
            font-size: 1rem;
            padding: 0.75rem 1rem;
        }

        .form-check-lg .form-check-input {
            transform: scale(1.2);
        }

        .alert-warning {
            border-left: 4px solid #ffc107;
        }

        .card-header {
            border-bottom: 2px solid #e9ecef;
        }

        .text-primary { color: #007bff !important; }
        .text-success { color: #28a745 !important; }
        .text-warning { color: #ffc107 !important; }
        .text-info { color: #17a2b8 !important; }
        .text-secondary { color: #6c757d !important; }

        #selected-files .file-item {
            transition: all 0.3s;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 12px;
            margin-bottom: 8px;
            background: white;
            position: relative;
        }

        #selected-files .file-item:hover {
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            border-color: #007bff;
        }

        .procedure-item {
            transition: all 0.2s;
            padding: 8px 12px;
            border-radius: 6px;
        }

        .procedure-item:hover {
            background-color: #f8f9fa;
        }
    </style>
@endsection

@section('scripts')
    @parent
    <script>
        $(document).ready(function() {
            // تحميل الإجراءات من localStorage أو استخدام القائمة الافتراضية
            let procedures = JSON.parse(localStorage.getItem('procedures')) || [
                'متابعة',
                'تدقيق',
                'مراجعة',
                'إبلاغ المشرف',
                'اجتماع',
                'زيارة',
                'ملاحظة'
            ];

            // تحديث localStorage
            function saveProcedures() {
                localStorage.setItem('procedures', JSON.stringify(procedures));
            }

            // تحديث القائمة المنسدلة عند تحميل الصفحة
            updateSelectOptions();

            // إضافة إجراء جديد
            $('#addProcedureBtn').on('click', function() {
                const name = $('#newProcedureName').val().trim();
                if (name && procedures.length < 6) {
                    procedures.push(name);
                    updateProceduresList();
                    updateSelectOptions();
                    saveProcedures();
                    $('#newProcedureName').val('');

                    // إظهار رسالة نجاح
                    showToast('تم إضافة الإجراء بنجاح', 'success');
                } else if (procedures.length >= 6) {
                    showToast('لا يمكن إضافة أكثر من 6 إجراءات', 'error');
                } else {
                    showToast('يرجى إدخال اسم الإجراء', 'warning');
                }
            });

            // تحديث قائمة الإجراءات في المودال
            function updateProceduresList() {
                let listHtml = '';
                procedures.forEach((proc, index) => {
                    const isFollowUp = proc === 'متابعة';
                    listHtml += `
                    <div class="procedure-item d-flex justify-content-between align-items-center mb-2">
                        <div class="d-flex align-items-center">
                            ${isFollowUp ? '<i class="fas fa-bell text-warning me-2"></i>' : '<i class="fas fa-circle-small text-muted me-2"></i>'}
                            <span class="${isFollowUp ? 'fw-bold text-warning' : ''}">${proc}</span>
                            ${isFollowUp ? '<span class="badge bg-warning text-dark ms-2">متابعة</span>' : ''}
                        </div>
                        <button class="btn btn-sm btn-outline-danger delete-procedure" data-index="${index}" ${index < 7 ? '' : ''}>
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>`;
                });
                $('#procedures-list').html(listHtml);
            }

            // عند فتح المودال
            $('#proceduresModal').on('show.bs.modal', function() {
                updateProceduresList();
            });

            // حذف إجراء
            $(document).on('click', '.delete-procedure', function() {
                const index = $(this).data('index');
                const procedureName = procedures[index];

                if (confirm(`هل أنت متأكد من حذف إجراء "${procedureName}"؟`)) {
                    procedures.splice(index, 1);
                    updateProceduresList();
                    updateSelectOptions();
                    saveProcedures();
                    showToast('تم حذف الإجراء بنجاح', 'success');
                }
            });

            // تحديث خيارات القائمة المنسدلة
            function updateSelectOptions() {
                let selectHtml = '<option value="">اختر نوع الإجراء</option>';
                procedures.forEach(proc => {
                    if (proc === 'متابعة') {
                        selectHtml += `<option value="${proc}" class="text-warning" data-follow-up="true">🔔 ${proc}</option>`;
                    } else {
                        selectHtml += `<option value="${proc}">${proc}</option>`;
                    }
                });
                selectHtml += '<option value="add_new" class="text-primary">+ تعديل قائمة الإجراءات</option>';
                $('#action_type').html(selectHtml);
            }

            // حفظ التغييرات
            $('#saveProcedures').on('click', function() {
                $('#proceduresModal').modal('hide');
                showToast('تم حفظ التغييرات بنجاح', 'success');
            });

            // السماح بالإضافة عند الضغط على Enter
            $('#newProcedureName').on('keypress', function(e) {
                if (e.which === 13) {
                    e.preventDefault();
                    $('#addProcedureBtn').click();
                }
            });

            // عند اختيار نوع الإجراء
            $('#action_type').on('change', function() {
                const selectedValue = $(this).val();

                if (selectedValue === 'add_new') {
                    $('#proceduresModal').modal('show');
                    $(this).val('');
                } else if (selectedValue === 'متابعة') {
                    showFollowUpAlert(true);
                } else {
                    showFollowUpAlert(false);
                }
            });

            // دالة إظهار/إخفاء تنبيه المتابعة
            function showFollowUpAlert(show) {
                if (show) {
                    $('#followUpAlert').removeClass('d-none').hide().fadeIn();
                } else {
                    $('#followUpAlert').fadeOut(function() {
                        $(this).addClass('d-none');
                    });
                }
            }

            // عداد الأحرف للملاحظة
            $('#description').on('input', function() {
                const length = $(this).val().length;
                $('#charCount').text(length + ' حرف');

                if (length > 500) {
                    $('#charCount').addClass('text-danger');
                } else {
                    $('#charCount').removeClass('text-danger');
                }
            });

            // تخصيص رسالة التأكيد قبل الإرسال
            let followUpConfirmed = false;

            $('#clientForm').on('submit', function(e) {
                const selectedProcess = $('#action_type').val();

                if (selectedProcess === 'متابعة' && !followUpConfirmed) {
                    e.preventDefault();
                    $('#followUpConfirmModal').modal('show');
                    return false;
                }

                // التحقق من المرفقات
                return validateAttachments();
            });
<<<<<<< HEAD

            // تأكيد المتابعة
            $('#confirmFollowUp').on('click', function() {
                followUpConfirmed = true;
                $('#followUpConfirmModal').modal('hide');
                $('#clientForm').submit();
            });

            // دالة عرض الرسائل المنبثقة
            function showToast(message, type) {
                const toastClass = type === 'success' ? 'bg-success' : type === 'error' ? 'bg-danger' : 'bg-warning';
                const toast = `
                    <div class="toast align-items-center text-white ${toastClass} border-0 position-fixed"
                         style="top: 20px; right: 20px; z-index: 9999;" role="alert">
                        <div class="d-flex">
                            <div class="toast-body">${message}</div>
                            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                        </div>
                    </div>`;

                $('body').append(toast);
                $('.toast').last().toast('show');

                // إزالة التوست بعد 3 ثوان
                setTimeout(function() {
                    $('.toast').last().remove();
                }, 3000);
            }
        });

        // دالة التحقق من النموذج
        function validateForm() {
            // التحقق من المرفقات
            if (!validateAttachments()) {
                return false;
            }

            // التحقق من الحقول المطلوبة
            const requiredFields = ['deposit_count', 'action_type', 'competitor_documents', 'description'];
            let isValid = true;

            requiredFields.forEach(function(field) {
                const element = document.getElementById(field === 'action_type' ? 'action_type' : field);
                if (!element.value.trim()) {
                    element.classList.add('is-invalid');
                    isValid = false;
                } else {
                    element.classList.remove('is-invalid');
                }
            });

            if (!isValid) {
                showToast('يرجى ملء جميع الحقول المطلوبة', 'error');
                return false;
            }

            return true;
        }

        function validateAttachments() {
            const files = document.getElementById('attachments').files;
            if (files.length === 0) {
                showToast('يرجى إرفاق ملف واحد على الأقل قبل إرسال النموذج', 'error');
                return false;
            }

            // التحقق من حجم الملفات
            for (let file of files) {
                if (file.size > 100 * 1024 * 1024) { // 100MB
                    showToast(`الملف "${file.name}" كبير جداً. الحد الأقصى 100 ميجابايت`, 'error');
                    return false;
                }
            }

            return true;
=======
        });
    </script>
<script>
    function previewSelectedFiles() {
        const input = document.getElementById('attachments');
        const preview = document.getElementById('selected-files');
        preview.innerHTML = '';

        if (input.files.length > 0) {
            const list = document.createElement('ul');
            list.classList.add('list-unstyled', 'mb-0');

            Array.from(input.files).forEach(file => {
                const listItem = document.createElement('li');
                listItem.innerHTML = `<i class="fas fa-check-circle text-success me-1"></i> ${file.name}`;
                list.appendChild(listItem);
            });

            preview.appendChild(list);
>>>>>>> 0865896ea3505cae60f0943c61cae726cbc1a34e
        }
    }
</script>
<script>
function validateAttachments() {
    const files = document.getElementById('attachments').files;
    if (files.length === 0) {
        alert('يرجى إرفاق ملف واحد على الأقل قبل إرسال النموذج.');
        return false; // يمنع الإرسال
    }
    return true; // يسمح بالإرسال
}

<<<<<<< HEAD
        function previewSelectedFiles() {
            const input = document.getElementById('attachments');
            const preview = document.getElementById('selected-files');
            preview.innerHTML = '';

            if (input.files.length === 0) return;

            const headerHtml = `
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="mb-0 text-primary">الملفات المختارة (${input.files.length})</h6>
                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="clearFiles()">
                        <i class="fas fa-trash me-1"></i>مسح الكل
                    </button>
                </div>`;

            preview.innerHTML = headerHtml;

            for (const file of input.files) {
                const fileSize = (file.size / 1024 / 1024).toFixed(2);
                const fileIcon = getFileIcon(file.type);

                const fileDiv = document.createElement('div');
                fileDiv.className = 'file-item d-flex align-items-center justify-content-between';
                fileDiv.innerHTML = `
                    <div class="d-flex align-items-center">
                        <i class="${fileIcon} fa-2x me-3"></i>
                        <div>
                            <div class="fw-bold">${file.name}</div>
                            <small class="text-muted">${fileSize} ميجابايت</small>
                        </div>
                    </div>
                    <div class="badge bg-primary">${getFileType(file.type)}</div>
                `;
                preview.appendChild(fileDiv);
            }
        }

        function getFileIcon(type) {
            if (type.startsWith('image/')) return 'fas fa-image text-info';
            if (type.startsWith('application/pdf')) return 'fas fa-file-pdf text-danger';
            if (type.startsWith('application/msword')) return 'fas fa-file-word text-primary';
            if (type.startsWith('application/vnd.openxmlformats-officedocument.wordprocessingml.document')) return 'fas fa-file-word text-primary';
            if (type.startsWith('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')) return 'fas fa-file-excel text-success';
            if (type.startsWith('application/vnd.ms-excel')) return 'fas fa-file-excel text-success';
            if (type.startsWith('application/')) return 'fas fa-file text-secondary';
            return 'fas fa-file text-secondary';
        }

        function getFileType(type) {
            if (type.startsWith('image/')) return 'صورة';
            if (type.startsWith('application/pdf')) return 'PDF';
            if (type.startsWith('application/msword')) return 'Word';
            if (type.startsWith('application/vnd.openxmlformats-officedocument.wordprocessingml.document')) return 'Word';
            if (type.startsWith('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')) return 'Excel';
            if (type.startsWith('application/vnd.ms-excel')) return 'Excel';
            if (type.startsWith('application/')) return 'ملف';
            return 'ملف';
        }

        function clearFiles() {
            const input = document.getElementById('attachments');
            input.value = '';
            previewSelectedFiles();
        }

        function toggleRecurringFields(checkbox) {
            const recurringFields = document.querySelectorAll('.recurring-fields');
            recurringFields.forEach(field => {
                field.style.display = checkbox.checked ? 'block' : 'none';
            });
        }

        function toggleStaffFields(checkbox) {
            const staffFields = document.querySelectorAll('.staff-fields');
            staffFields.forEach(field => {
                field.style.display = checkbox.checked ? 'block' : 'none';
            });
        }

        function toggleClientFields(checkbox) {
            const clientFields = document.querySelectorAll('.client-fields');
            clientFields.forEach(field => {
                field.style.display = checkbox.checked ? 'block' : 'none';
            });
        }

        function toggleServiceFields(checkbox) {
            const serviceFields = document.querySelectorAll('.service-fields');
            serviceFields.forEach(field => {
                field.style.display = checkbox.checked ? 'block' : 'none';
            });
        }

        function toggleProductFields(checkbox) {
            const productFields = document.querySelectorAll('.product-fields');
            productFields.forEach(field => {
                field.style.display = checkbox.checked ? 'block' : 'none';
            });
        }
    </script>
=======
function previewSelectedFiles() {
    const input = document.getElementById('attachments');
    const preview = document.getElementById('selected-files');
    preview.innerHTML = '';
    for (const file of input.files) {
        const fileDiv = document.createElement('div');
        fileDiv.textContent = file.name;
        fileDiv.classList.add('border', 'p-2', 'rounded', 'mb-2', 'bg-white');
        preview.appendChild(fileDiv);
    }
}
</script>


>>>>>>> 0865896ea3505cae60f0943c61cae726cbc1a34e
@endsection
