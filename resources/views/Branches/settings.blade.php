@extends('master')

@section('title')
    أعدادات الفروع
@stop

@section('content')

    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">أعدادات الفروع </h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="">الرئيسيه</a></li>
                            <li class="breadcrumb-item active">أضافة</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
   
    <form action="{{ route('branches.settings_store') }}" method="POST" enctype="multipart/form-data">
        @csrf
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div>
                    <label>الحقول التي عليها علامة <span style="color: red">*</span> الزامية</label>
                </div>
                <div>
                    
                        <button type="submit" class="btn btn-outline-primary">
                            <i class="fa fa-save"></i> حفظ
                        </button>
                </div>
            </div>
        </div>
    </div>
    @if (Session::has('success'))
    <div class="alert alert-success text-xl-center" role="alert">
        <p class="mb-0">
            {{ Session::get('success') }}
        </p>
    </div>
@endif

    @if ($branchs->isEmpty())
    <div class="alert alert-warning">
        لا توجد فروع متاحة. يرجى إضافة فروع أولاً.
    </div>
@else

    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div>
                    <!-- تسمية الحقل -->
                    <label for="name" class="form-label">الفرع الرئيسي</label>
                    <form id="branch-form">
                        <select id="branch_id" class="form-control" name="branch_id">
                            @foreach ($branchs as $branch)
                                <option value="{{ $branch->id }}" {{ $selectedBranchId == $branch->id ? 'selected' : '' }}>
                                    {{ $branch->name ?? '' }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                </div>
            </div>
            <div id="settings-container">
                @if (isset($settings))
                    <div class="col-md-6 mb-3" id="branch-settings">
                        @foreach ($branch->settings as $setting)
                            <div class="vs-checkbox-con vs-checkbox-primary">
                                <input type="checkbox" name="{{ $setting->key }}" value="1" 
                                       {{ isset($settings[$setting->key]) && $settings[$setting->key] == 1 ? 'checked' : '' }}>
                                <span class="vs-checkbox">
                                    <span class="vs-checkbox--check">
                                        <i class="vs-icon feather icon-check"></i>
                                    </span>
                                </span>
                                <span>{{ $setting->name }}</span>
                                <small class="text-muted">
                                    {{ isset($settings[$setting->key]) && $settings[$setting->key] == 1 ? 'مفعلة' : 'غير مفعلة' }}
                                </small>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

        </div>
    </div>

    </form>
    @endif
@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // عند تغيير الفرع من الـ select
    $('#branch_id').change(function () {
        var branchId = $(this).val();  // جلب ID الفرع المختار
        $.ajax({
            url: '{{ route('settings.get') }}',  // استدعاء الـ route الخاص بـ AJAX
            method: 'GET',
            data: {branch_id: branchId},  // إرسال ID الفرع المختار
            success: function (response) {
                var settings = response.settings;
                var settingsHtml = '';

                // بناء الـ HTML الجديد للصلاحيات بناءً على البيانات
                settingsHtml += '<div class="col-md-6 mb-3" id="branch-settings">';
                settings.forEach(function(setting) {
                    var status = setting.status == 1 ? 'checked' : '';
                    var statusText = setting.status == 1 ? 'مفعلة' : 'غير مفعلة';
                    settingsHtml += `
                        <div class="vs-checkbox-con vs-checkbox-primary">
                            <input type="checkbox" name="${setting.key}" value="1" ${status}>
                            <span class="vs-checkbox">
                                <span class="vs-checkbox--check">
                                    <i class="vs-icon feather icon-check"></i>
                                </span>
                            </span>
                            <span>${setting.name}</span>
                            <small class="text-muted">${statusText}</small>
                        </div>
                    `;
                });
                settingsHtml += '</div>';

                // تحديث حاوية الصلاحيات في الصفحة
                $('#settings-container').html(settingsHtml);
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error:", error);  // تسجيل الخطأ في الـ Console
            }
        });
    });
});
    </script>
<script>
    // عند تغيير الفرع من الـ select
    $(document).on('change', 'input[type="checkbox"]', function () {
    var settingKey = $(this).attr('name'); // استخدام الـ name بدلاً من data-key
    var status = $(this).prop('checked') ? 1 : 0;

    // إرسال حالة الصلاحية إلى السيرفر عبر AJAX
    $.ajax({
        url: '{{ route('branches.settings_store') }}',  // استدعاء الـ route الخاص بالحفظ
        method: 'POST',
        data: {
            branch_id: $('#branch_id').val(),
            [settingKey]: status,
            _token: '{{ csrf_token() }}'
        },
        success: function (response) {
            console.log("Response:", response); // فحص الاستجابة
        },
        error: function (xhr, status, error) {
            console.error("AJAX Error:", error);  // تسجيل الخطأ في الـ Console
        }
    });
});
</script>