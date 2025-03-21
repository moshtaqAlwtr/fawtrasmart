@extends('master')

@section('title')
   اعدادات العميل
@stop
<style>
    /* تخصيص الـ checkbox */
    .form-check-input.custom-checkbox {
     
        accent-color: blue; /* تغيير لون الـ checkbox إلى الأزرق */
      /* إضافة مسافة بين الـ checkbox والنص */
    }
    
    /* تخصيص النص بجانب الـ checkbox */
    .form-check-label.custom-label {
      /* زيادة حجم النص */
        color: #333; /* لون النص */
     
    }
    </style>
@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
           
            </div>
        </div>
    </div>
    <div class="content-body">
        <form id="clientForm" action="{{ route('clients.store_general') }}" method="POST" enctype="multipart/form-data">
            @csrf

            @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <div>
                            <label>الحقول التي عليها علامة <span style="color: red">*</span> الزامية</label>
                        </div>

                        <div>
                            <a href="{{ route('clients.index') }}" class="btn btn-outline-danger">
                                <i class="fa fa-ban"></i>الغاء
                            </a>
                            <button type="submit" class="btn btn-outline-primary">
                                <i class="fa fa-save"></i>حفظ
                            </button>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row">
                <!-- الحقول الإضافية على اليسار -->
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">الحقول الاضافية للعميل</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="form-body">
                                    <div class="row">
                                        @foreach ($settings as $setting)
                                            <div class="col-md-12">
                                                <div class="form-check">
                                                    <input
                                                        type="checkbox"
                                                        class="form-check-input custom-checkbox"
                                                        id="setting_{{ $setting->id }}"
                                                        name="settings[]"
                                                        value="{{ $setting->id }}"
                                                        {{ $setting->is_active ? 'checked' : '' }}
                                                    >
                                                    <label class="form-check-label" for="setting_{{ $setting->id }}">
                                                        {{ $setting->name }}
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            
                <!-- نوع العميل على اليمين -->
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">اعدادات العميل</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="form-body">
                                    <div class="row">
                                        <!-- نوع العميل -->
                                        <div class="col-12 mb-3">
                                            <div class="form-group">
                                                <label for="trade_name"> نوع العميل <span class="text-danger">*</span></label>
                                                <div class="position-relative has-icon-left">
                                                    <select name="type" class="form-control">
                                                        <option value="Both" {{ $selectedType === 'Both' ? 'selected' : '' }}>كلاهما</option>
                                                        <option value="individual" {{ $selectedType === 'individual' ? 'selected' : '' }}>فردي</option>
                                                        <option value="commercial" {{ $selectedType === 'commercial' ? 'selected' : '' }}>تجاري</option>
                                                    </select>
                                                    <div class="form-control-position">
                                                        <i class="feather icon-briefcase"></i>
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

        </form>
    </div>


    </div>
    </div>

    <!------------------------->


@endsection

@section('scripts')

    <script src="{{ asset('assets/js/scripts.js') }}"></script>
    <script>
        document.getElementById('clientForm').addEventListener('submit', function(e) {
            // e.preventDefault(); // احذف هذا السطر إذا كنت تريد أن يتم إرسال النموذج

            console.log('تم تقديم النموذج');

            // طباعة جميع البيانات المرسلة
            const formData = new FormData(this);
            for (let pair of formData.entries()) {
                console.log(pair[0] + ': ' + pair[1]);
            }
        });
    </script>
@endsection

