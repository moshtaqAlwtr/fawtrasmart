@extends('master')

@section('title')
    تعديل طلب شراء
@stop

@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">تعديل طلب شراء</h2>
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
        <form class="form" action="{{ route('OrdersPurchases.update', $purchaseOrder->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
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


            <div class="card" style="max-width: 90%; margin: 0 auto;">
                <h1>
                </h1>
                <div class="card-body">

                    <div class="form-body row">


                        <div class="form-group col-md-4">
                            <label for="contract_date" class="">مسممى</label>
                            <input type="text" class="form-control" name="title" placeholder="مسمى" value="{{ old('title', $purchaseOrder->title) }}">

                        </div>
                        <div class="form-group col-md-4">
                            <label for="feedback1" class=""> الكود </label>
                            <input type="text" id="feedback1" class="form-control" placeholder="الكود" name="code" value="{{ old('code', $purchaseOrder->code) }}">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="feedback1" class=""> تاريخ الطلب </label>
                            <input type="date" id="feedback1" class="form-control" name="order_date" value="{{ old('order_date', $purchaseOrder->order_date) }}">
                        </div>
                    </div>

                    <div class="form-body row">
                        <div class="form-group col-md-4">
                            <label for="feedback1" class=""> تاريخ الاستحقاق </label>
                            <input type="date" id="feedback1" class="form-control" name="due_date" value="{{ old('due_date', $purchaseOrder->due_date) }}">
                        </div>

                    </div>

                </div>


            </div>
            <div class="card" style="max-width: 90%; margin: 0 auto; margin-top: 20px">
                <div class="card-body">





                    <div class="mt-4">
                        <h6>المنتج</h6>
                        <div class="table-responsive">
                            <table class="table">
                                <thead style="background: #e9ecef">
                                    <tr>
                                        <th style="width: 50px"></th>
                                        <th>بند</th>
                                        <th>الكمية</th>
                                        <th style="width: 50px"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr id="newRow2" style="display: none; background-color: #fff7d6;">
                                        <td class="align-middle text-center">
                                            <i class="fas fa-grip-vertical text-muted"></i>
                                        </td>
                                        <td>
                                            <div class="position-relative">
                                                <select class="form-control item-select"
                                                    name="product_details[0][product_id]" value="{{ old('product_details.0.product_id', $purchaseOrder->product_id) }}" data-type="deduction">
                                                    <option value="">اختر البند</option>
                                                    @foreach ($products as $product)
                                                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </td>
                                        <td>
                                            <input type="number" class="form-control amount-input" placeholder="ادخل كمية" value="{{ old('product_details.0.quantity', $purchaseOrder->quantity) }}"
                                                name="product_details[0][quantity]" min="1">
                                        </td>
                                        <td class="align-middle text-center">
                                            <i class="fas fa-minus-circle text-danger remove-row"
                                                style="cursor: pointer;"></i>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <a class="btn btn-success add-row-button-deduction">
                                <i class="fas fa-plus"></i> إضافة
                            </a>
                        </div>
                    </div>


                </div>

            </div>



            <div class="card" style="max-width: 90%; margin: 0 auto; margin-top: 20px">
                <div class="card-body">
                    <!-- الملاحظات -->
                    <div class="mt-4"></div>
                        <h6 class="mb-2">الملاحظات</h6>
                        <textarea class="form-control" name="notes" rows="4" placeholder="اكتب ملاحظاتك هنا...">{{ old('notes', $purchaseOrder->notes) }}</textarea>
                    </div>
                    <div class="mt-4">
                        <div class="form-group">
                            <label for="attachments">المرفقات</label>
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


        </form>
    </div>


@endsection

@section('scripts')
    <script src="{{ asset('assets/js/salaries.js') }}"></script>
@endsection
