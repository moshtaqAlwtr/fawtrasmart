@extends('master')

@section('title', 'إضافة ملاحظة أو مرفق')

@section('content')
<div class="container mt-4">
    <form action="{{ route('appointment.notes.store') }}" method="POST" enctype="multipart/form-data">
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
                    <div class="col-md-2.5">
                        <label for="date" class="form-label">التاريخ</label>
                        <input type="date" class="form-control" name="date" value="{{ date('Y-m-d') }}">
                    </div>
                    <div class="col-md-1.5">
                        <label for="time" class="form-label">الوقت</label>
                        <input type="time" class="form-control" name="time" value="{{ date('H:i') }}">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="time" class="form-label">اختار الحالة </label>
                        <select class="form-control" name="client_id" >
                            @foreach($clients as $client)
                                <option value="{{ $client->id }}">
                                    @if($client->client_type == 1)
                                        عميل عادي
                                    @elseif($client->client_type == 2)
                                        عميل VIP
                                    @else
                                        غير محدد
                                    @endif
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="time" class="form-label">اختر الاجراء</label>

                        <select class="form-control" name="appointment_id" >
                            <option value="">اختر الاجراء</option>
                            @foreach($appointments as $appointment)
                                <option value="{{ $appointment->id }}">{{ $appointment->action_type }} </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Dropdowns -->


                         <!-- Notes -->
                <div class="mb-3">
                    <label for="notes" class="form-label">ملاحظة</label>
                    <textarea class="form-control" name="notes" rows="4"></textarea>
                </div>

                <!-- Attachments -->
                <div class="mt-4">
                    <h5 class="mb-3">المرفقات</h5>
                    <div class="upload-area p-4 border rounded bg-light text-center">
                        <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-3"></i>
                        <p class="mb-1">أفلت الملف هنا أو <label class="text-primary">اختر من جهازك</label></p>
                        <input type="file" name="attachments" class="form-control mt-3" multiple>
                    </div>
                </div>

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
