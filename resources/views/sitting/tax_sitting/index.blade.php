@extends('master')

@section('title')
   تحديث الضريبة
@stop

@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0"> تحديث الضريبة </h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="">الرئيسيه</a></li>
                            <li class="breadcrumb-item active">عرض </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.alerts.success')
        <!-- عرض الأخطاء -->
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
                        <form  action="{{ route('TaxSitting.update') }}" method="POST">
                            @csrf
                        <a href="" class="btn btn-outline-danger">
                            <i class="fa fa-ban"></i>الغاء
                        </a>
                        <button type="submit" class="btn btn-outline-primary">
                            <i class="fa fa-save"></i>  تحديث الضريبة
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <!-- الحقول -->
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="name" class="form-label">اسم الضريبة <span style="color: red">*</span></label>
                        <input type="text" id="name" name="name" class="form-control" placeholder="اسم الضريبة"
                            value="{{ old('name', $tax->name ?? '') }}" required>
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
            
                    <div class="col-md-4">
                        <label for="tax" class="form-label">الضريبة <span style="color: red">*</span></label>
                        <input type="number" id="tax" name="tax" class="form-control" placeholder="نسبة الضريبة"
                            step="0.01" value="{{ old('tax', $tax->tax ?? '') }}" required>
                        @error('tax')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
            
                    <div class="col-md-4">
                        <label for="tax_type" class="form-label">نوع الضريبة <span style="color: red">*</span></label>
                        <select id="tax_type" name="type" class="form-control" required>
                            <option value="excluded" {{ old('type', $tax->type ?? 'excluded') == 'excluded' ? 'selected' : '' }}>غير متضمن</option>
                            <option value="included" {{ old('type', $tax->type ?? 'excluded') == 'included' ? 'selected' : '' }}>متضمن</option>
                        </select>
                        @error('type')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            
            
        </div>
    </form>
</div>
@endsection


