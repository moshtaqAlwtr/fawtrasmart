@extends('master')

@section('title')
المستودعات
@stop

@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">المستودعات</h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="">الرئيسيه</a>
                            </li>
                            <li class="breadcrumb-item active">اضافه
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="content-body">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <div>
                        <label>الحقول التي عليها علامة <span style="color: red">*</span> الزامية</label>
                    </div>

                    <div>
                        <a href="{{ route('storehouse.index') }}" class="btn btn-outline-danger btn-sm">
                            <i class="fa fa-ban"></i>الغاء
                        </a>
                        <button type="submit" form="products_form" class="btn btn-outline-primary btn-sm">
                            <i class="fa fa-save"></i>حفظ
                        </button>
                    </div>

                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5>بيانات المستودع</h5>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <form id="products_form" class="form form-vertical" action="{{ route('storehouse.store') }}" method="POST">
                        @csrf
                        <div class="form-body">
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="first-name-icon">الاسم <span style="color: red">*</span></label>
                                        <div class="position-relative has-icon-left">
                                            <input type="text" id="first-name-icon" class="form-control" name="name" placeholder="اسم المستودع" value="{{ old('name') }}">
                                            <div class="form-control-position">
                                                <i class="feather icon-box"></i>
                                            </div>
                                            @error('name')
                                            <span class="text-danger" id="basic-default-name-error" class="error">
                                                {{ $message }}
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="first-name-icon">الحاله</label>
                                        <select class="form-control" id="basicSelect" name="status">
                                            <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>نشط</option>
                                            <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>غير نشط</option>
                                            <option value="2" {{ old('status') == 2 ? 'selected' : '' }}>موقوف</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="email-id-icon">عنوان الشحن</label>
                                        <div class="position-relative has-icon-left">
                                            <textarea name="shipping_address" class="form-control" rows="2">{{ old('shipping_address') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-6">
                                    <fieldset class="checkbox">
                                        <div class="vs-checkbox-con vs-checkbox-primary">
                                            <input type="checkbox" name="major">
                                            <span class="vs-checkbox">
                                                <span class="vs-checkbox--check">
                                                    <i class="vs-icon feather icon-check"></i>
                                                </span>
                                            </span>
                                            <span class="">مستودع رئيسي</span>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="card">
                            <div class="card-header">
                                <h5>الصلاحيات</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="first-name-icon">عرض</label>
                                            <select class="form-control" id="view_permissions" name="view_permissions">
                                                <option selected value="0">الكل</option>
                                                <option value="1">موظف محدد</option>
                                                <option value="2">دور وظيفي محدد</option>
                                                <option value="3">فرع محدد</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="first-name-icon">انشاء فاتورة</label>
                                            <select class="form-control" id="crate_invoices_permissions" name="crate_invoices_permissions">
                                                <option value="0">الكل</option>
                                                <option value="1">موظف محدد</option>
                                                <option value="2">دور وظيفي محدد</option>
                                                <option value="3">فرع محدد</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="first-name-icon">تعديل المستودع</label>
                                            <select class="form-control" id="edit_stock_permissions" name="edit_stock_permissions">
                                                <option value="0">الكل</option>
                                                <option value="1">موظف محدد</option>
                                                <option value="2">دور وظيفي محدد</option>
                                                <option value="3">فرع محدد</option>
                                            </select>
                                        </div>
                                    </div>

                                </div>

                                <div class="row">

                                    <div class="col-4">
                                        <div class="form-group" style='display: none' id="employee_id">
                                            <label for="first-name-icon">اختر الموظف</label>
                                            <select class="form-control" name="v_employee_id">
                                                @foreach ($employees as $employee)
                                                    <option value="1">{{ $employee->full_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group" style='display: none' id="functional_role_id">
                                            <label for="first-name-icon">اختر الدور الوظيفي</label>
                                            <select class="form-control" name="v_functional_role_id">
                                                @foreach ($job_roles as $job_role)
                                                    <option value="{{ $job_role->id }}" {{ old('v_functional_role_id') == $job_role->id ? 'selected' : '' }}>{{ $job_role->role_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group" style='display: none' id="branch_id">
                                            <label for="first-name-icon">اختر الفرع</label>
                                            <select class="form-control" name="v_branch_id">
                                                @foreach ($branches as $branch)
                                                    <option value="{{ $branch->id }}" {{ old('v_branch_id') == $branch->id ? 'selected' : '' }}>{{ $branch->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-4">
                                        <div class="form-group" style='display: none' id="1employee_id">
                                            <label for="first-name-icon">اختر الموظف</label>
                                            <select class="form-control" name="c_employee_id">
                                                @foreach ($employees as $employee)
                                                    <option value="{{ $employee->id }}" {{ old('c_employee_id') == $employee->id ? 'selected' : '' }}>{{ $employee->full_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group" style='display: none' id="1functional_role_id">
                                            <label for="first-name-icon">اختر الدور الوظيفي</label>
                                            <select class="form-control" name="c_functional_role_id">
                                                @foreach ($job_roles as $job_role)
                                                    <option value="{{ $job_role->id }}" {{ old('c_functional_role_id') == $job_role->id ? 'selected' : '' }}>{{ $job_role->role_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group" style='display: none' id="1branch_id">
                                            <label for="first-name-icon">اختر الفرع</label>
                                            <select class="form-control" name="c_branch_id">
                                                @foreach ($branches as $branch)
                                                    <option value="{{ $branch->id }}" {{ old('c_branch_id') == $branch->id ? 'selected' : '' }}>{{ $branch->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-4">
                                        <div class="form-group" style='display: none' id="2employee_id">
                                            <label for="first-name-icon">اختر الموظف</label>
                                            <select class="form-control" name="e_employee_id">
                                                @foreach ($employees as $employee)
                                                    <option value="{{ $employee->id }}" {{ old('e_employee_id') == $employee->id ? 'selected' : '' }}>{{ $employee->full_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group" style='display: none' id="2functional_role_id">
                                            <label for="first-name-icon">اختر الدور الوظيفي</label>
                                            <select class="form-control" name="e_functional_role_id">
                                                @foreach ($job_roles as $job_role)
                                                    <option value="{{ $job_role->id }}" {{ old('e_functional_role_id') == $job_role->id ? 'selected' : '' }}>{{ $job_role->role_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group" style='display: none' id="2branch_id">
                                            <label for="first-name-icon">اختر الفرع</label>
                                            <select class="form-control" name="e_branch_id">
                                                @foreach ($branches as $branch)
                                                    <option value="{{ $branch->id }}" {{ old('e_branch_id') == $branch->id ? 'selected' : '' }}>{{ $branch->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection


@section('scripts')

<script>
    document.getElementById('view_permissions').onchange = function(){
        if(this.value == 1){
            document.getElementById('employee_id').style.display = '';
            document.getElementById('functional_role_id').style.display = 'none';
            document.getElementById('branch_id').style.display = 'none';
        } else if(this.value == 2) {
            document.getElementById('functional_role_id').style.display = '';
            document.getElementById('branch_id').style.display = 'none';
            document.getElementById('employee_id').style.display = 'none';
        } else if(this.value == 3) {
            document.getElementById('branch_id').style.display = '';
            document.getElementById('employee_id').style.display = 'none';
            document.getElementById('functional_role_id').style.display = 'none';
        }
        else{
            document.getElementById('branch_id').style.display = 'none';
            document.getElementById('employee_id').style.display = 'none';
            document.getElementById('functional_role_id').style.display = 'none';
        }
    };
</script>

<script>
    document.getElementById('crate_invoices_permissions').onchange = function(){
        if(this.value == 1){
            document.getElementById('1employee_id').style.display = '';
            document.getElementById('1functional_role_id').style.display = 'none';
            document.getElementById('1branch_id').style.display = 'none';
        } else if(this.value == 2) {
            document.getElementById('1functional_role_id').style.display = '';
            document.getElementById('1branch_id').style.display = 'none';
            document.getElementById('1employee_id').style.display = 'none';
        } else if(this.value == 3) {
            document.getElementById('1branch_id').style.display = '';
            document.getElementById('1employee_id').style.display = 'none';
            document.getElementById('1functional_role_id').style.display = 'none';
        }
        else{
            document.getElementById('1branch_id').style.display = 'none';
            document.getElementById('1employee_id').style.display = 'none';
            document.getElementById('1functional_role_id').style.display = 'none';
        }
    };
</script>

<script>
    document.getElementById('edit_stock_permissions').onchange = function(){
        if(this.value == 1){
            document.getElementById('2employee_id').style.display = '';
            document.getElementById('2functional_role_id').style.display = 'none';
            document.getElementById('2branch_id').style.display = 'none';
        } else if(this.value == 2) {
            document.getElementById('2functional_role_id').style.display = '';
            document.getElementById('2branch_id').style.display = 'none';
            document.getElementById('2employee_id').style.display = 'none';
        } else if(this.value == 3) {
            document.getElementById('2branch_id').style.display = '';
            document.getElementById('2employee_id').style.display = 'none';
            document.getElementById('2functional_role_id').style.display = 'none';
        }
        else{
            document.getElementById('2branch_id').style.display = 'none';
            document.getElementById('2employee_id').style.display = 'none';
            document.getElementById('2functional_role_id').style.display = 'none';
        }
    };
</script>

@endsection
