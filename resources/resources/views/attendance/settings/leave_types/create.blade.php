@extends('master')

@section('title', 'نوع الإجازات')

@section('content')
    <!-- Header Section -->
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">نوع الإجازات</h2>
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

    <!-- Form Actions -->
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div>
                    <label>الحقول التي عليها علامة <span style="color: red">*</span> الزامية</label>
                </div>
                <div>
                    <a href="{{ route('leave_types.index') }}" class="btn btn-outline-danger">
                        <i class="fa fa-ban"></i> إلغاء
                    </a>
                    <button type="submit" form="addLeaveTypeForm" class="btn btn-outline-primary">
                        <i class="fa fa-save"></i> حفظ
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Section -->
    <div class="card">
        <div class="card-body">
            <h4 class="mb-4">معلومات نوع الإجازات</h4>
            <form id="addLeaveTypeForm" method="POST" action="{{ route('leave_types.store') }}">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label for="employee" class="form-label">الاسم <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="application-date" name="name" value="{{ old('name') }}">
                    </div>

                    <div class="col-md-4">
                        <label for="start-date" class="form-label">اللون <span class="text-danger">*</span></label>
                        <input type="text" disabled id="colorDisplay" class="form-control" value="#9a4d40">
                        <input type="hidden" name="color" id="colorHidden" class="form-control" value="#9a4d40">

                    </div>

                    <div class="col-md-2 mt-2">
                        <input type="text" id="colorPicker" class="form-control" value="#9a4d40">
                    </div>

                    <div class="col-md-6 mb-2">
                        <label for="employee" class="form-label">الحد الأقصى للأيام خلال العام <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="max_days_per_year" value="{{ old('max_days_per_year') }}">
                    </div>

                    <div class="col-md-6 mb-2">
                        <label for="employee" class="form-label">الحد الأقصى للأيام المتوالية القابلة للتطبيق</label>
                        <input type="number" class="form-control" name="max_consecutive_days" value="{{ old('max_consecutive_days') }}">
                    </div>

                    <div class="col-md-6 mb-2">
                        <label for="employee" class="form-label">قابلة للتطبيق بعد</label>
                        <input type="number" class="form-control" name="applicable_after" value="{{ old('applicable_after') }}">
                    </div>

                    <div class="col-md-3">
                        <div class="vs-checkbox-con vs-checkbox-primary">
                            <label for=""></label>
                            <input type="checkbox" name="requires_approval" value="true" {{ old('requires_approval') == 1 ? 'checked' : '' }}>
                            <span class="vs-checkbox">
                                <span class="vs-checkbox--check">
                                    <i class="vs-icon feather icon-check"></i>
                                </span>
                            </span>
                            <span class="">يحتاج إذن</span>
                        </div>
                    </div>


                    <div class="col-md-3">
                        <div class="vs-checkbox-con vs-checkbox-primary">
                            <label for=""></label>
                            <input type="checkbox" name="replace_weekends" value="true" {{ old('replace_weekends') == 1 ? 'checked' : '' }}>
                            <span class="vs-checkbox">
                                <span class="vs-checkbox--check">
                                    <i class="vs-icon feather icon-check"></i>
                                </span>
                            </span>
                            <span class="">استبدال أيام عطلة نهاية الأسبوع بالإجازة</span>
                        </div>
                    </div>



                    <div class="col-md-12">
                        <label for="description" class="form-label">الوصف</label>
                        <textarea class="form-control" id="description" rows="2" placeholder="أدخل الوصف" name="description">{{ old('description') }}</textarea>
                    </div>

                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            $("#colorPicker").spectrum({
                showPalette: true,
                showInput: true,
                preferredFormat: "hex",
                palette: [
                    ["#9a4d40", "#f44336", "#e91e63", "#9c27b0", "#673ab7"],
                    ["#3f51b5", "#2196f3", "#03a9f4", "#00bcd4", "#009688"],
                    ["#4caf50", "#8bc34a", "#cddc39", "#ffeb3b", "#ffc107"]
                ],
                i18n: {
                    cancelText: "إلغاء",
                    chooseText: "اختيار اللون",
                    clearText: "مسح اللون",
                    noColorSelectedText: "لم يتم اختيار لون"
                },

                change: function (color) {
                    // تحديث الحقل المعطل بقيمة اللون الجديد
                    $("#colorDisplay").val(color.toHexString());
                    $("#colorHidden").val(color.toHexString());
                }
            });
        });
    </script>
@endsection
