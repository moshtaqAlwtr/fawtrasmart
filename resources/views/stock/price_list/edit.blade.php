@extends('master')

@section('title')
قوائم الأسعار
@stop

@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">ادارة قوائم الأسعار</h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="">الرئيسيه</a>
                            </li>
                            <li class="breadcrumb-item active">تعديل
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="content-body">
        <div class="card">
            <div class="card-header"></div>
            <div class="card-body">
                <form class="form form-vertical" action="{{ route('price_list.update',$price_list->id) }}" method="POST">
                    @csrf
                    <div class="form-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="first-name-vertical">الاسم</label>
                                    <input type="text" value="{{ old('name',$price_list->name) }}" class="form-control" name="name" placeholder="اخل اسم قامه الاسعار">
                                    @error('name')
                                    <span class="text-danger" id="basic-default-name-error" class="error">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="email-id-vertical">الحالة</label>
                                    <select class="form-control" id="basicSelect" name="status">
                                        <option value="0" {{ old('status',$price_list->status) == 0 ? 'selected' : '' }}>نشط</option>
                                        <option value="1" {{ old('status',$price_list->status) == 1 ? 'selected' : '' }}>موقوف</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12">
                                <button type="submit" class="btn btn-primary mr-1 mb-1 waves-effect waves-light">تحديث</button>
                                <button type="reset" class="btn btn-outline-warning mr-1 mb-1 waves-effect waves-light">تفريغ</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
@endsection
