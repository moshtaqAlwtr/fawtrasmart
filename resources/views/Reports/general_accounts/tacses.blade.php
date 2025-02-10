@extends('master')

@section('title')
تخصيص التدفقات النقدية
@stop


@section('content')




<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-left mb-0">تخصيص التدفقات النقدية</h2>
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




 


<div class="container mt-4" dir="rtl">

    <!-- القسم الأول -->
    <div class="mb-4">
        <div class="bg-light p-2 mb-2 fw-bold border">تدفق البيانات من العمليات</div>
        <table class="table table-bordered table-hover text-center align-middle" id="operations-table">
            <thead class="table-secondary">
                <tr>
                <th>الاسم</th>
                <th>الحساب</th>
                <th>النوع</th>
                <th>عرض</th>
                <th>الإجراء</th>  
                </tr>
            </thead>
            <tbody>
                <tr>
                <td>صافي الدخل</td>
                <td>مخصص</td>
                <td>التغير في المال</td>
                <td>
    <!-- زر القائمة المنسدلة -->
    <div class="dropdown">
        <button class="btn btn-info btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            فضلاً اختر
        </button>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#" onclick="showContent()">عرض</a></li>
            <li><a class="dropdown-item" href="#" onclick="hideContent()">إخفاء</a></li>
        </ul>
    </div>
</td>
                    <td>
                        <button class="btn btn-danger btn-sm" onclick="removeRow(this)">
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>
                   
                  
                    
                   
                </tr>
            </tbody>
        </table>
        <button class="btn btn-success btn-sm" onclick="addRow('operations-table')">إضافة</button>
    </div>

    <!-- القسم الثاني -->
    <div class="mb-4">
        <div class="bg-light p-2 mb-2 fw-bold border">تدفق البيانات من الاستثمارات</div>
        <table class="table table-bordered table-hover text-center align-middle" id="investments-table">
            <thead class="table-secondary">
            <tr>
                <th>الاسم</th>
                <th>الحساب</th>
                <th>النوع</th>
                <th>عرض</th>
                <th>الإجراء</th>  
            </tr>
            </thead>
            <tbody>
                <tr>
                <td>النقد المستخدم في الأصول</td>
                <td>مخصص</td>
                <td>التغير في المال</td>
                <td>
    <!-- زر القائمة المنسدلة -->
    <div class="dropdown">
        <button class="btn btn-info btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            فضلاً اختر
        </button>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#" onclick="showContent()">عرض</a></li>
            <li><a class="dropdown-item" href="#" onclick="hideContent()">إخفاء</a></li>
        </ul>
    </div>
</td>
                    <td>
                        <button class="btn btn-danger btn-sm" onclick="removeRow(this)">
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>
                   
                </tr>
            </tbody>
        </table>
        <button class="btn btn-success btn-sm" onclick="addRow('investments-table')">إضافة</button>
    </div>

    <!-- القسم الثالث -->
    <div class="mb-4">
        <div class="bg-light p-2 mb-2 fw-bold border">تدفق البيانات من التمويل</div>
        <table class="table table-bordered table-hover text-center align-middle" id="financing-table">
            <thead class="table-secondary">
            <tr>
                <th>الاسم</th>
                <th>الحساب</th>
                <th>النوع</th>
                <th>عرض</th>
                <th>الإجراء</th>  
            </tr>
            </thead>
            <tbody>
                <tr>
                <td>إضافة الأموال المشتركة</td>
                <td>مخصص</td>
                <td>التغير في المال</td>
                <td>
    <!-- زر القائمة المنسدلة -->
    <div class="dropdown">
        <button class="btn btn-info btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            فضلاً اختر
        </button>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#" onclick="showContent()">عرض</a></li>
            <li><a class="dropdown-item" href="#" onclick="hideContent()">إخفاء</a></li>
        </ul>
    </div>
</td>
                    <td>
                        <button class="btn btn-danger btn-sm" onclick="removeRow(this)">
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>
                   
                </tr>
            </tbody>
        </table>
        <button class="btn btn-success btn-sm" onclick="addRow('financing-table')">إضافة</button>
    </div>
</div>


<script>
    // وظيفة لإضافة سطر جديد
    function addRow(tableId) {
        const table = document.getElementById(tableId).getElementsByTagName('tbody')[0];
        const newRow = table.insertRow();

        newRow.innerHTML = `
        <td>صف جديد</td>
         <td>مخصص</td>
          <td>التغير في المال</td>
           <td><a href="#" class="btn btn-info btn-sm">عرض</a></td>
            <td>
                <button class="btn btn-danger btn-sm" onclick="removeRow(this)">
                    <i class="fa fa-trash"></i>
                </button>
            </td>
           
           
           
            
        `;
    }

    // وظيفة لحذف الصف عند الضغط على زر الإزالة
    function removeRow(button) {
        const row = button.parentNode.parentNode; // الحصول على الصف المحدد
        row.parentNode.removeChild(row); // حذف الصف
    }
</script>
<script>
    function showContent() {
        alert('تم اختيار: عرض');
        // أضف الكود هنا لإظهار محتوى معين
    }

    function hideContent() {
        alert('تم اختيار: إخفاء');
        // أضف الكود هنا لإخفاء محتوى معين
    }
</script>





@endsection