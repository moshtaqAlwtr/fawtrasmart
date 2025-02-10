@extends('master')

@section('title')
    تعديل عضوية
@stop

@section('content')
    <div style="font-size: 1.1rem;">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0"> تعديل  عضوية </h2>
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
            <div class="card mb-5">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
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

            <form class="form mt-4" style="font-size: 1.1rem;">
                <div class="card" style="max-width: 90%; margin: 0 auto;">
                    <div class="card-header">
                        <h1>
                            تفاصيل العضوية
                        </h1>
                    </div>
                    <div class="card-body">
                        <div class="form-body row mb-5 align-items-center">
                            <div class="form-group col-md-4 mb-3">
                                <label for="feedback2" class="">العميل <span class="text-danger">*</span></label>
                                <select name="client_id" class="form-control" id="">
                                    @foreach ($clients as $client)
                                        <option value="{{ $client->id }}">{{ $client->first_name }}
                                            {{ $client->last_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-2 mb-3.5 d-flex align-items-end">
                                <a href="{{ route('clients.create') }}" class="btn btn-success w-100">
                                    <i class="fa fa-plus"></i> اضافة عميل
                                </a>
                            </div>
                            <div class="form-group col-md-6 mb-3">
                                <label for="feedback1" class="">الباقة <span class="text-danger">*</span></label>
                                <select name="status" class="form-control" id="">
                                    <option value="1">الباقة</option>
                                </select>
                            </div>
                        </div>


                        <div class="form-body row mb-5">
                            <div class="form-group col-md-6 mb-3">
                                <label for="feedback1" class=""> تاريخ الالتحاق <span
                                        class="text-danger">*</span></label>
                                <input type="date" class="form-control">
                            </div>
                            <div class="form-group col-md-6 mb-3">
                                <label for="feedback1" class=""> تاريخ الفاتورة <span
                                        class="text-danger">*</span></label>
                                <input type="date" class="form-control">
                            </div>


                        </div>


                        <div class="form-body row mb-5">
                            <div class="form-group col-md-6 mb-3">
                                <label for="feedback1" class="">الوصف <span class="text-danger">*</span></label>
                                <textarea class="form-control"></textarea>
                            </div>

                        </div>
                    </div>

                </div>


            </form>

        </div>









    </div>




@endsection
