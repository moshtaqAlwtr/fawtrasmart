@extends('master')

@section('title', 'إضافة ملاحظة أو مرفق')

@section('content')
    <div class="container mt-4">
        <form id="clientForm" action="{{ route('clients.addnotes') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="current_latitude" id="current_latitude">
            <input type="hidden" name="current_longitude" id="current_longitude">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <div>
                            <label>الحقول التي عليها علامة <span style="color: red">*</span> الزامية</label>
                        </div>
                        <div>
                            <a href="{{ route('appointments.index') }}" class="btn btn-outline-danger">
                                <i class="fa fa-ban"></i>الغاء
                            </a>
                            <button type="submit" class="btn btn-outline-primary">
                                <i class="fa fa-save"></i>حفظ
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Section -->
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <!-- Date and Time -->
                    <div class="row mb-3">
                        <div class="form-group col-md-6">
                            <label for="action_type">نوع الإجراء</label>
                            <select class="form-control" id="action_type" name="process" required>
                                <option value="">اختر نوع الإجراء</option>
                                <option value="add_new" class="text-primary">+ تعديل قائمة الإجراءات</option>
                            </select>
                            <input type="hidden" name="client_id" value="{{ $id }}">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="time" class="form-label">اختر الحالة</label>
                            <div class="dropdown col-md-6">
                                <button class="btn btn-light dropdown-toggle text-start w-100" type="button"
                                    id="clientStatusDropdown" data-bs-toggle="dropdown" aria-expanded="false"
                                    style="background-color: {{ $currentStatus->color ?? '#ffffff' }};
                                           color: #000;
                                           border: 1px solid #ccc;">
                                    {{ $currentStatus->name ?? 'اختر الحالة' }}
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end w-100" aria-labelledby="clientStatusDropdown"
                                    style="border-radius: 8px;">
                                    @foreach ($statuses as $status)
                                        <li>
                                            <a href="#"
                                                class="dropdown-item text-white d-flex align-items-center justify-content-between status-option"
                                                data-id="{{ $status->id }}" data-name="{{ $status->name }}"
                                                data-color="{{ $status->color }}"
                                                style="background-color: {{ $status->color }};">
                                                <span><i class="fas fa-thumbtack me-1"></i> {{ $status->name }}</span>
                                            </a>
                                        </li>
                                    @endforeach
                                    <li>
                                        <a href="{{ route('SupplyOrders.edit_status') }}"
                                            class="dropdown-item text-muted d-flex align-items-center justify-content-center"
                                            style="border-top: 1px solid #ddd; padding: 8px;">
                                            <i class="fas fa-cog me-2"></i> تعديل قائمة الحالات
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- New Fields -->
                    <div class="row mb-3">
                        <!-- عدد العهدة -->
                        <div class="form-group col-md-4">
                            <label for="deposit_count" class="form-label">عدد العهدة الموجودة</label>
                            <input type="number" class="form-control" id="deposit_count" name="deposit_count" min="0">
                        </div>

                        <!-- نوع الموقع -->
                        <div class="form-group col-md-4">
                            <label for="site_type" class="form-label">نوع الموقع</label>
                            <select class="form-control" id="site_type" name="site_type">
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
                            <input type="number" class="form-control" id="competitor_documents" name="competitor_documents" min="0">
                        </div>
                    </div>

                    <!-- Notes -->
                    <div class="mb-3">
                        <label for="notes" class="form-label">ملاحظة</label>
                        <textarea class="form-control" name="description" rows="4"></textarea>
                    </div>

                    <!-- Attachments -->
                    <div class="col-md-12 col-12 mb-3">
                        <div class="form-group">
                            <label for="attachments" class="form-label">المرفقات</label>
                            <input type="file" name="attachments[]" multiple id="attachments" class="form-control d-none"
                                onchange="previewSelectedFiles()">
                            <div class="upload-area border rounded p-4 text-center position-relative bg-light"
                                onclick="document.getElementById('attachments').click()" style="cursor: pointer;">
                                <div class="d-flex flex-column align-items-center justify-content-center gap-2">
                                    <i class="fas fa-cloud-upload-alt fa-2x text-primary"></i>
                                    <p class="mb-0 text-primary fw-bold">اضغط هنا أو اختر من جهازك</p>
                                    <small class="text-muted">يمكنك رفع صور، فيديوهات، وملفات PDF/Word/Excel</small>
                                </div>
                                <div class="position-absolute end-0 top-50 translate-middle-y me-3">
                                    <i class="fas fa-file-alt fs-3 text-secondary"></i>
                                </div>
                            </div>
                            <div id="selected-files" class="mt-3"></div>
                        </div>
                    </div>

                    <!-- Options -->
                    <div class="form-check mt-3">
                        <input class="form-check-input" type="checkbox" name="share_with_work" id="shareWithWork">
                        <label class="form-check-label" for="shareWithWork">مشاركة مع العمل</label>
                    </div>
                </div>
            </div>
        </form>
    </div>
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
                } else if (procedures.length >= 6) {
                    alert('لا يمكن إضافة أكثر من 6 إجراءات');
                }
            });

            // تحديث قائمة الإجراءات في المودال
            function updateProceduresList() {
                let listHtml = '';
                procedures.forEach((proc, index) => {
                    listHtml += `
                <div class="d-flex justify-content-between align-items-center mb-2 border-bottom pb-2">
                    <span>${proc}</span>
                    <button class="btn btn-sm btn-outline-danger delete-procedure" data-index="${index}">
                        <i class="fas fa-trash"></i> حذف
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
                procedures.splice(index, 1);
                updateProceduresList();
                updateSelectOptions();
                saveProcedures();
            });

            // تحديث خيارات القائمة المنسدلة
            function updateSelectOptions() {
                let selectHtml = '<option value="">اختر نوع الإجراء</option>';
                procedures.forEach(proc => {
                    selectHtml += `<option value="${proc}">${proc}</option>`;
                });
                selectHtml += '<option value="add_new" class="text-primary">+ تعديل قائمة الإجراءات</option>';
                $('#action_type').html(selectHtml);
            }

            // حفظ التغييرات
            $('#saveProcedures').on('click', function() {
                $('#proceduresModal').modal('hide');
            });

            // السماح بالإضافة عند الضغط على Enter
            $('#newProcedureName').on('keypress', function(e) {
                if (e.which === 13) {
                    e.preventDefault();
                    $('#addProcedureBtn').click();
                }
            });

            // عند اختيار "تعديل قائمة الإجراءات" من القائمة المنسدلة
            $('#action_type').on('change', function() {
                if ($(this).val() === 'add_new') {
                    $('#proceduresModal').modal('show');
                    $(this).val(''); // إعادة تحديد القيمة إلى فارغة
                }
            });

            // التعامل مع خيار التكرار
            $('#is_recurring').change(function() {
                if ($(this).is(':checked')) {
                    $('#recurring_options').slideDown();
                } else {
                    $('#recurring_options').slideUp();
                }
            });

            // التعامل مع خيار تعيين موظف
            $('#assign_employee').change(function() {
                if ($(this).is(':checked')) {
                    $('#employee_options').slideDown();
                } else {
                    $('#employee_options').slideUp();
                }
            });

            // تحميل قائمة الموظفين
            function loadEmployees() {
                $.get('/employees/list', function(data) {
                    let options = '<option value="">اختر الموظف</option>';
                    data.forEach(function(employee) {
                        options += `<option value="${employee.id}">${employee.name}</option>`;
                    });
                    $('#employee_id').html(options);
                });
            }

            // تحميل الموظفين عند تفعيل خيار تعيين موظف
            $('#assign_employee').change(function() {
                if ($(this).is(':checked')) {
                    loadEmployees();
                }
            });
        });

        // دالة إظهار/إخفاء حقول التكرار
        function toggleRecurringFields(checkbox) {
            const recurringFields = document.getElementById('recurring-fields');
            if (checkbox.checked) {
                recurringFields.style.display = 'block';
            } else {
                recurringFields.style.display = 'none';
            }
        }

        // دالة إظهار/إخفاء حقول الموظفين
        function toggleStaffFields(checkbox) {
            const staffFields = document.getElementById('staff-fields');
            if (checkbox.checked) {
                staffFields.style.display = 'block';
            } else {
                staffFields.style.display = 'none';
            }
        }
        document.querySelectorAll('.status-option').forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();

                let statusName = this.getAttribute('data-name');
                let statusColor = this.getAttribute('data-color');

                let dropdownButton = document.getElementById('clientStatusDropdown');
                dropdownButton.innerText = statusName;
                dropdownButton.style.backgroundColor = statusColor;
            });
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
        }
    }
</script>

@endsection
