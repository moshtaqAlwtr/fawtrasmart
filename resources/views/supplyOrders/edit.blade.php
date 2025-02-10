
@extends('master')

@section('title')
    تعديل  امر تشغيل
@stop

@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">تعديل امر تشغيل</h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="">الرئيسيه</a>
                            </li>
                            <li class="breadcrumb-item active">عرض
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <div class="content-body">
        <div class="container-fluid">
            <form class="form-horizontal" action="" method="post" novalidate>

                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <div>
                                <label>الحقول التي عليها علامة <span style="color: red">*</span> الزامية</label>
                            </div>

                            <div>
                                <a href="" class="btn btn-outline-danger">
                                    <i class="fa fa-ban"></i>الغاء
                                </a>
                                <button type="submit" class="btn btn-outline-primary">
                                    <i class="fa fa-save"></i>حفظ
                                </button>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <h4 class="card-title">معلومات اوامر التوريد </h4>
                        </div>

                        <div class="card-body">
                            <form class="form">
                                <div class="form-body row">

                                    <div class="form-group col-md-3">
                                        <label for="feedback2" class="sr-only"> مسمى</label>
                                        <input type="email" id="feedback2" class="form-control" placeholder="مسمى "
                                            name="email">
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label for="feedback2" class="sr-only"> رقم امر </label>
                                        <input type="email" id="feedback2" class="form-control" placeholder=" رقم امر  "
                                            name="email">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="feedback2" class="sr-only"> تاريخ البدء </label>
                                        <input type="date" id="feedback2" class="form-control"
                                            placeholder=" تاريخ البدء  " name="email">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="feedback2" class="sr-only"> تاريخ النهاية </label>
                                        <input type="date" id="feedback2" class="form-control"
                                            placeholder=" تاريخ  النهاية   " name="email">
                                    </div>

                                </div>

                                <div class="form-group col-md-12">
                                    <label for="feedback2" class="sr-only">الوصف </label>
                                    <textarea id="feedback2" class="form-control" rows="5" placeholder="الوصف " name="email"></textarea>
                                </div>
                                <div class="form-body row">
                                    <div class="col-md-3 d-flex gap-2">
                                        <select id="feedback2" class="form-control">
                                            <option value="">اختر عميل</option>
                                            @foreach ($clients as $client)
                                                <option value="{{ $client->id }}">{{ $client->trade_name }}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                    <div class="col-md-1">
                                        <a href="{{ route('clients.create') }}" class="btn btn-success">جديد</a>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <select id="feedback2" class="form-control">
                                            <option value="">اي وسم</option>
                                            <option value=""></option>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-2">
                                        <input type="text" id="feedback2" class="form-control" placeholder="الميزانية"
                                            name="email">
                                    </div>

                                    <div class="form-group col-md-2">
                                        <select id="feedback2" class="form-control">
                                            <option value="">SAR</option>
                                            <option value=""></option>
                                        </select>
                                    </div>
                                </div>


                            </form>

                        </div>

                    </div>

                </div>






            </form>
        </div>


        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="d-flex align-items-center">
                        <a href="#" data-bs-toggle="modal" data-bs-target="#customFieldsModal">
                            <i class="fas fa-cog me-2"></i>
                            <span>إعدادات الحقول المخصصة</span>
                        </a>
                    </div>
                    <div>
                        <span>بيانات الشحنة</span>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 mb-3">
                        <label class="form-label text-end d-block">بيانات المنتجات</label>
                        <textarea class="form-control" rows="4"></textarea>
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label text-end d-block">عنوان الشحن</label>
                        <textarea class="form-control" rows="4"></textarea>
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label text-end d-block">رقم التتبع</label>
                        <input type="text" class="form-control">
                    </div>

                    <div class="col-12">
                        <label class="form-label text-end d-block">بوليصة الشحن</label>


                            <div class="form-group">

                                <input type="file" name="attachments" id="attachments" class="d-none">
                                <div class="upload-area border rounded p-3 text-center position-relative"
                                    onclick="document.getElementById('attachments').click()">
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
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="customFieldsModal" tabindex="-1" aria-labelledby="customFieldsModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header border-0">
                        <h5 class="modal-title" id="customFieldsModalLabel">إعدادات الحقول المخصصة</h5>
                        <button type="button" class="btn-close" data-bs-toggle="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-info" role="alert">
                            You will be redirected to edit the custom fields page
                        </div>
                    </div>
                    <div class="modal-footer justify-content-start border-0">
                        <button type="button" class="btn btn-success">
                            <i class="fas fa-check me-1"></i>
                            حفظ
                        </button>
                        <button type="button" class="btn btn-danger">
                            عدم الحفظ
                        </button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            إلغاء
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    <script src="{{ asset('assets/js/invoice.js') }}"></script>


@endsection
