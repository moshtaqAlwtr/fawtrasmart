@extends('master')

@section('title', 'إضافة ملاحظة أو مرفق')

@section('content')
    <div class="container mt-4">
        <form id="clientForm" action="{{ route('clients.addnotes') }}" method="POST" enctype="multipart/form-data">
            @csrf
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
            <!-- Header Section -->

            <!-- Form Section -->
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <!-- Date and Time -->
                    <div class="row mb-3">
                        {{-- <div class="col-md-2">
                            <label for="date" class="form-label">التاريخ</label>
                            <input type="date" class="form-control" name="date" value="{{ date('Y-m-d') }}">
                        </div>
                        <div class="col-md-2">
                            <label for="time" class="form-label">الوقت</label>
                            <input type="time" class="form-control" name="time" value="{{ date('H:i') }}">
                        </div> --}}
                        <div class="form-group col-md-6">
                            <label for="time" class="form-label">اختار الاجراء </label>
                            <select class="form-control" id="action_type" name="process" required>
                                <option value="">اختر الإجراء</option>
                                <option value="متابعة هاتفية">متابعة هاتفية</option>
                                <option value="تحصيل">تحصيل</option>
                                <option value="توصيل">توصيل</option>
                                <option value="حجز">حجز</option>
                            </select>
                            <input type="hidden" name="client_id" value="{{$id}}" >
                         

                        </div>

                        <!-- Modal -->
                        <div class="modal fade" id="proceduresModal" tabindex="-1" aria-labelledby="proceduresModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="proceduresModalLabel">تعديل قائمة الإجراءات</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div id="procedures-list">
                                            <!-- القائمة ستضاف هنا -->
                                        </div>
                                        <div class="mt-3">
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="newProcedureName"
                                                    placeholder="اسم الإجراء الجديد">
                                                <button class="btn btn-primary" type="button" id="addProcedureBtn">
                                                    <i class="fas fa-plus"></i> إضافة
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">إلغاء</button>
                                        <button type="button" class="btn btn-success" id="saveProcedures">حفظ</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="time" class="form-label">اختر الحالة</label>

                            <select class="form-control" name="status">
                                <option value="">اختر الحالة</option>
                                <option class="btn btn-warning" value="مديون">مديون</option>
                                <option class="btn btn-danger" value="دائن">دائن</option>
                                <option class="btn btn-primary" value="مميز">مميز</option>
                            </select>
                        </div>

                    </div>

                    <!-- Notes -->
                    <div class="mb-3">
                        <label for="notes" class="form-label">ملاحظة</label>
                        <textarea class="form-control" name="description" rows="4"></textarea>
                    </div>

                    <!-- Attachments -->
                    {{-- <div class="mt-4">
                        <h5 class="mb-3">المرفقات</h5>
                        <div class="upload-area p-4 border rounded bg-light text-center">
                            <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-3"></i>
                            <p class="mb-1">أفلت الملف هنا أو <label class="text-primary">اختر من جهازك</label></p>
                            <input type="file" name="attachments" class="form-control mt-3" multiple>
                        </div>
                    </div> --}}

                    <!-- Options -->
                    <div class="form-check mt-3">
                        <input class="form-check-input" type="checkbox" name="share_with_work" id="shareWithWork">
                        <label class="form-check-label" for="shareWithWork">مشاركة مع العمل</label>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="d-flex justify-content-center mt-4">
                <button type="button" class="btn btn-outline-secondary me-2">تحديد موعد جديد</button>
            </div>
        </form>
    </div>
@endsection
@section('scripts')
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
            // function updateSelectOptions() {
            //     let selectHtml = '<option value="">اختر نوع الإجراء</option>';
            //     procedures.forEach(proc => {
            //         selectHtml += `<option value="${proc}">${proc}</option>`;
            //     });
            //     selectHtml += '<option value="add_new" class="text-primary">+ تعديل قائمة الإجراءات</option>';
            //     $('#action_type').html(selectHtml);
            // }

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
    </script>
@endsection
