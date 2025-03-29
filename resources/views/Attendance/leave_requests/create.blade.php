@extends('master')

@section('title', 'إضافة طلب إجازة')

@section('content')
    <!-- Header Section -->
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">إضافة طلب إجازة</h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">الرئيسية</a></li>
                            <li class="breadcrumb-item active">إضافة</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

<<<<<<< HEAD
    <form id="leave-request-form" method="POST" action="{{ route('attendance.leave_requests.store') }}"
        enctype="multipart/form-data">
        @csrf
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
                {{ session('error') }}
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- أزرار الإجراءات -->
        <div class="card mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <div>
                        <span class="text-muted">الحقول المميزة بعلامة <span class="text-danger">*</span> إلزامية</span>
                    </div>
                    <div>
                        <a href="{{ route('Assets.index') }}" class="btn btn-outline-danger">
                            <i class="fas fa-ban"></i> إلغاء
                        </a>
                        <button type="submit" form="leave-request-form" class="btn btn-outline-primary">
                            <i class="fas fa-save"></i> حفظ
                        </button>
                    </div>
=======
    <!-- Form Actions -->
    <div class="card mb-3">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div>
                    <label>الحقول التي عليها علامة <span style="color: red">*</span> الزامية</label>
                </div>
                <div>
                    <a href="{{ route('Assets.index') }}" class="btn btn-outline-danger">
                        <i class="fa fa-ban"></i> إلغاء
                    </a>
                    <button type="submit" class="btn btn-outline-primary">
                        <i class="fa fa-save"></i> حفظ
                    </button>
>>>>>>> 7a9e4574bccad6056952352da4d0a63fce63cdf8
                </div>
            </div>
        </div>
    </div>
    <div class="card mt-4">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title mb-4">معلومات طلب الإجازة</h4>
            <form>
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label for="employee" class="form-label">موظف <span class="text-danger">*</span></label>
                        <select class="form-control" id="employee" required>
                            <option selected disabled>اختر موظف</option>
                            <!-- Add options here -->
                        </select>
                        <hr>
                        <p class="text-primary" >تفقد رصيد الإجازات</p>
                    </div>
                    <div class="col-md-6">
                        <label for="type" class="form-label">النوع <span class="text-danger">*</span></label>
                        <select class="form-control" id="type" required>
                            <option selected disabled>إجازة</option>
                            <!-- Add options here -->
                        </select>
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-4">
                        <label for="days" class="form-label">أيام <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="days" placeholder="تفقد رصيد الإجازات" required>
                    </div>
                    <div class="col-md-4">
                        <label for="start-date" class="form-label">تاريخ البدء <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="start-date" required>
                    </div>
                    <div class="col-md-4">
                        <label for="end-date" class="form-label">تاريخ الانتهاء <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="end-date" required>
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label for="leave-type" class="form-label">نوع الإجازة <span class="text-danger">*</span></label>
<<<<<<< HEAD
                        <select class="form-control" id="leave-type" name="leave_type_id" required>
                            <option value="annual" selected>نوع الإجازة</option>
                            @foreach ($leaveTypes as $leaveType)
                                <option value="{{ $leaveType->id }}">{{ $leaveType->name }}</option>
                            @endforeach

=======
                        <select class="form-control" id="leave-type" required>
                            <option selected disabled>أجازة أعتيادية</option>
                            <option>أجازة عرضية </option>
                            <!-- Add options here -->
>>>>>>> 7a9e4574bccad6056952352da4d0a63fce63cdf8
                        </select>
                        <hr>
                        <p class="text-primary">رصيد الأجازات 0</p>
                    </div>
                    <div class="col-md-6">
                        <label for="attachments" class="form-label">المرفقات</label>
<<<<<<< HEAD
                        <input type="file" name="attachments" id="attachments" class="d-none" multiple>
                        <div class="upload-area border rounded p-3 text-center position-relative"
                            onclick="document.getElementById('attachments').click()">
=======
                        <input type="file" name="attachments" id="attachments" class="d-none">
                        <div class="upload-area border rounded p-3 text-center position-relative" onclick="document.getElementById('attachments').click()">
>>>>>>> 7a9e4574bccad6056952352da4d0a63fce63cdf8
                            <div class="d-flex align-items-center justify-content-center gap-2">
                                <i class="fas fa-cloud-upload-alt text-primary"></i>
                                <span class="text-primary">اضغط هنا</span>
                                <span>أو</span>
                                <span class="text-primary">اختر من جهازك</span>
                            </div>
                            <div class="position-absolute end-0 top-50 translate-middle-y me-3">
                                <i class="fas fa-file-alt fs-3 text-secondary"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">الوصف</label>
<<<<<<< HEAD
                    <textarea class="form-control" id="description" name="description" rows="3"
                        placeholder="أدخل وصفًا لطلب الإجازة (اختياري)"></textarea>
                </div>

            </div>
        </div>
    </form>

    <!-- مودال رصيد الإجازات -->
    <div class="modal fade" id="leaveBalanceModal" tabindex="-1" role="dialog"
        aria-labelledby="leaveBalanceModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="leaveBalanceModalLabel">رصيد الإجازات</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>نوع الإجازة</th>
                                    <th>المستحق</th>
                                    <th>المستخدم</th>
                                    <th>المتبقي</th>
                                </tr>
                            </thead>
                            <tbody id="leave-balance-details">
                                <!-- سيتم ملؤها بالجافاسكريبت -->
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // عرض الملفات المرفوعة
            $('#attachments').change(function() {
                let files = $(this)[0].files;
                let fileList = $('#file-list');
                fileList.empty();

                if (files.length > 0) {
                    for (let i = 0; i < files.length; i++) {
                        fileList.append('<div><i class="fas fa-file mr-2"></i>' + files[i].name + '</div>');
                    }
                } else {
                    fileList.append('<div>لم يتم اختيار أي ملفات</div>');
                }
            });

            // حساب التواريخ عند تغيير تاريخ البدء أو عدد الأيام
            $('#start-date, #days').on('change', function() {
                calculateDates();
            });

            // حساب عدد الأيام عند تغيير تاريخ الانتهاء
            $('#end-date').on('change', function() {
                calculateDays();
            });

            // جلب رصيد الإجازات عند اختيار موظف
            $('#employee').change(function() {
                let employeeId = $(this).val();
                if (employeeId) {
                    $.ajax({
                        url: '/employees/' + employeeId + '/leave-balance',
                        method: 'GET',
                        success: function(data) {
                            $('#leave-balance').text(data.balance);

                            // تحديث جدول رصيد الإجازات في المودال
                            let balanceDetails = '';
                            data.details.forEach(function(item) {
                                balanceDetails += `
                                    <tr>
                                        <td>${item.type}</td>
                                        <td>${item.entitled}</td>
                                        <td>${item.used}</td>
                                        <td>${item.remaining}</td>
                                    </tr>
                                `;
                            });
                            $('#leave-balance-details').html(balanceDetails);
                        },
                        error: function() {
                            $('#leave-balance').text('0');
                            $('#leave-balance-details').html(
                                '<tr><td colspan="4">لا يوجد بيانات</td></tr>');
                        }
                    });
                }
            });

            // دالة حساب تاريخ الانتهاء بناءً على تاريخ البدء وعدد الأيام
            function calculateDates() {
                let startDate = new Date($('#start-date').val());
                let days = parseInt($('#days').val());

                if (startDate && !isNaN(days) && days > 0) {
                    let endDate = new Date(startDate);
                    endDate.setDate(endDate.getDate() + days - 1);

                    // تحويل التاريخ إلى صيغة YYYY-MM-DD
                    let formattedDate = endDate.toISOString().split('T')[0];
                    $('#end-date').val(formattedDate);
                }
            }

            // دالة حساب عدد الأيام بناءً على تاريخي البدء والانتهاء
            function calculateDays() {
                let startDate = new Date($('#start-date').val());
                let endDate = new Date($('#end-date').val());

                if (startDate && endDate && startDate <= endDate) {
                    let diffTime = endDate - startDate;
                    let diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
                    $('#days').val(diffDays);
                }
            }
        });
    </script>
@endsection
=======
                    <textarea class="form-control" id="description" rows="3" placeholder="أدخل الوصف"></textarea>
                </div>

              
            </form>
        </div>
    </div>
</div>
@endsection
>>>>>>> 7a9e4574bccad6056952352da4d0a63fce63cdf8
