@extends('master')

@section('title')
    اضافة عضوية
@stop

@section('content')
    <div style="font-size: 1.1rem;">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0"> اضافة عضوية </h2>
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="">الرئيسيه</a></li>
                                <li class="breadcrumb-item active">عرض</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <form id="clientForm" action="{{ route('Memberships.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="content-body">
                <div class="card mb-5">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
                            <div>
                                <label>الحقول التي عليها علامة <span style="color: red">*</span> الزامية</label>
                            </div>
                            <div>
                                <a href="" class="btn btn-outline-danger">
                                    <i class="fa fa-ban"></i> الغاء
                                </a>
                                <button type="submit" class="btn btn-outline-primary">
                                    <i class="fa fa-save"></i> حفظ
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card" style="max-width: 90%; margin: 0 auto;">
                    <div class="card-header">
                        <h1>تفاصيل العضوية</h1>
                    </div>
                    <div class="card-body">
                        <div class="form-body row mb-5 align-items-center">
                            <div class="form-group col-md-4 mb-3">
                                <label for="client_id" class="">العميل <span class="text-danger">*</span></label>
                                <select name="client_id" class="form-control @error('client_id') is-invalid @enderror">
                                    <option value="">اختر العميل</option>
                                    @foreach ($clients as $client)
                                        <option value="{{ $client->id }}" {{ old('client_id') == $client->id ? 'selected' : '' }}>
                                            {{ $client->first_name }} {{ $client->last_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('client_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-2 mb-3 d-flex align-items-end">
                                <a href="{{ route('clients.create') }}" class="btn btn-success w-100">
                                    <i class="fa fa-plus"></i> اضافة عميل
                                </a>
                            </div>
                            <div class="form-group col-md-6 mb-3">
                                <label for="package_id" class="">الباقة <span class="text-danger">*</span></label>
                                <select name="package_id" class="form-control @error('package_id') is-invalid @enderror">
                                    <option value="">اختر الباقة</option>
                                    @foreach ($packages as $package)
                                        <option value="{{ $package->id }}" {{ old('package_id') == $package->id ? 'selected' : '' }}>
                                            {{ $package->commission_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('package_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-body row mb-5">
                            <div class="form-group col-md-6 mb-3">
                                <label for="join_date" class="">تاريخ الالتحاق <span class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('join_date') is-invalid @enderror" 
                                       name="join_date" value="{{ old('join_date') }}">
                                @error('join_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6 mb-3">
                                <label for="end_date" class="">تاريخ الانتهاء<span class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('end_date') is-invalid @enderror" 
                                       name="end_date" value="{{ old('end_date') }}">
                                @error('end_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group col-md-12 mb-3">
                            <label for="description" class="">الوصف <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      name="description">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
