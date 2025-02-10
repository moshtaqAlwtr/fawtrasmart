@extends('master')

@section('title')
الميزانية العمومية


@stop


@section('content')




<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-left mb-0">الميزانية العمومية</h2>
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


<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-right align-items-center gap-2 flex-wrap">
            <!-- زر شهري -->
            <button type="button" class="btn btn-outline-success">
                <i class="fa fa-calendar"></i> شهري
            </button>
            <!-- زر الطباعة -->
            <button type="button" class="btn btn-outline-secondary" onclick="window.print()">
                <i class="fa fa-print"></i> طباعة
            </button>
            <!-- زر خيارات التصدير -->
            <div class="dropdown">
                <button class="btn btn-outline-info dropdown-toggle" type="button" id="exportDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-file-export"></i> خيارات التصدير
                </button>
                <ul class="dropdown-menu" aria-labelledby="exportDropdown">
                    <li><a class="dropdown-item" href="#">تصدير كـ PDF</a></li>
                    <li><a class="dropdown-item" href="#">تصدير كـ Excel</a></li>
                    <li><a class="dropdown-item" href="#">تصدير كـ CSV</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>



    <div class="card shadow-sm p-3 mb-5 bg-body rounded">
        <h5 class="card-title mb-3">Filters</h5>
        <form>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="dateFrom" class="form-label">الفترة من / إلى:</label>
                    <input type="text" id="dateFrom" class="form-control" placeholder="الفترة من / إلى">
                </div>
                <div class="col-md-4">
                        <label for="account">فرع الحسابات:</label>
                        <select class="form-control" id="account">
                            <option>أختر</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="journal">فرع القيود:</label>
                        <select class="form-control" id="journal">
                            <option> أختر</option>
                        </select>
                    </div>
                
            </div>
            <div class="row mb-3">
            <div class="col-md-4">
                        <label for="measure">المستويات:</label>
                        <select class="form-control" id="measure">
                            <option>أختر مستوى </option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="">مراكز التكلفة:</label>
                        <select class="form-control" id="">
                            <option> أختر مركز</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="account">عرض جميع الحسابات:</label>
                        <select class="form-control" id="account">
                            <option>الكل </option>
                        </select>
                    </div>
            </div>
            <button type="submit" class="btn btn-primary">عرض التقرير</button>
        </form>
    </div>
   
        <!-- البطاقة الرئيسية -->
        <!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الميزانية العمومية</title>
    <!-- رابط مكتبة Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- رابط Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body style="background-color: #f8f9fa; direction: rtl; text-align: right;">

<div class="container mt-5">
    <!-- بطاقة الميزانية العمومية -->
    <div class="card shadow">
        <div class="card-header bg-primary text-white text-center">
            <h4>📊 مؤسسة أعمال خاصة للتجارة</h4>
            <h5>الميزانية العمومية - بتاريخ 17/12/2024</h5>
        </div>
        <div class="card-body">
            <p><strong>📌 الفرع:</strong> كل الفروع</p>
            <p><strong>📌 الفترة:</strong> من 16/12/2024</p>
            <p><strong>📌 مراكز التكلفة:</strong> كل مراكز التكلفة</p>

            <!-- جدول الأصول -->
            <h5 class="mt-4">الأصول</h5>
            <table class="table table-bordered">
                <thead class="table-primary">
                    <tr>
                        <th>رقم الحساب</th>
                        <th>اسم الحساب</th>
                        <th>المبلغ (ر.س)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>11</td>
                        <td>الأصول الثابتة</td>
                        <td>0.00</td>
                    </tr>
                    <tr>
                        <td colspan="3" class="text-center"><strong>تفاصيل الأصول الثابتة</strong></td>
                    </tr>
                    <tr>
                        <td>112</td>
                        <td>الأجهزة والمعدات</td>
                        <td>0.00</td>
                    </tr>
                    <tr>
                        <td>113</td>
                        <td>وسائل النقل</td>
                        <td>0.00</td>
                    </tr>
                    <tr>
                        <td>114</td>
                        <td>مباني</td>
                        <td>0.00</td>
                    </tr>
                    <tr>
                        <td>115</td>
                        <td>أراضي</td>
                        <td>0.00</td>
                    </tr>
                    <tr>
                        <td>116</td>
                        <td>برامج وأجهزة</td>
                        <td>0.00</td>
                    </tr>
                    <tr>
                        <td>117</td>
                        <td>أثاث مكتب</td>
                        <td>0.00</td>
                    </tr>
                    <tr>
                        <td>118</td>
                        <td>عدد وأدوات متنوعة</td>
                        <td>0.00</td>
                    </tr>
                    <tr>
                        <td>12</td>
                        <td>الأصول المتداولة</td>
                        <td>0.00</td>
                    </tr>
                    <tr>
                        <td colspan="3" class="text-center"><strong>تفاصيل الأصول المتداولة</strong></td>
                    </tr>
                    <tr>
                        <td>121</td>
                        <td>الخزينة</td>
                        <td>510.00</td>
                    </tr>
                    <tr>
                        <td>122</td>
                        <td>البنك</td>
                        <td>0.00</td>
                    </tr>
                    <tr>
                        <td>123</td>
                        <td>المخزون</td>
                        <td>-1,530</td>
                    </tr>
                    <tr>
                        <td>124</td>
                        <td>المدينون</td>
                        <td>1,020</td>
                    </tr>
                    <tr>
                        <td colspan="3" class="text-center"><strong>تفاصيل المدينون</strong></td>
                    </tr>
                    <tr>
                        <td>1241</td>
                        <td>العملاء</td>
                        <td>1,020</td>
                    </tr>
                    <tr>
                        <td>1242</td>
                        <td>أطراف مدينة أخرى</td>
                        <td>0.00</td>
                    </tr>
                    <tr>
                        <td>1243</td>
                        <td>العامل حسن</td>
                        <td>0.00</td>
                    </tr>
                    <tr>
                        <td>1244</td>
                        <td>عامر الأحمد السوري</td>
                        <td>0.00</td>
                    </tr>
                    <tr>
                        <td>1245</td>
                        <td>أبو بكر</td>
                        <td>0.00</td>
                    </tr>
                    <tr>
                        <td>1246</td>
                        <td>سلام الهادي</td>
                        <td>0.00</td>
                    </tr>
                    <tr>
                        <td>1247</td>
                        <td>سلفة أبو فالح</td>
                        <td>0.00</td>
                    </tr>
                    <tr>
                        <td>1248</td>
                        <td>ضريبة القيمة المضافة 15%</td>
                        <td>0.00</td>
                    </tr>
                    <tr>
                        <td>1249</td>
                        <td>مشرف / محمد الشرقاوي</td>
                        <td>0.00</td>
                    </tr>
                    <tr>
                        <td>1250</td>
                        <td>أحمد رشيد</td>
                        <td>0.00</td>
                    </tr>
                    <tr>
                        <td>1251</td>
                        <td>أحمد حمدي المحاسب</td>
                        <td>0.00</td>
                    </tr>
                    <tr>
                        <td>1252</td>
                        <td>محمد الحليق</td>
                        <td>0.00</td>
                    </tr>
                    <tr>
                        <td>126</td>
                        <td>أوراق القبض</td>
                        <td>0.00</td>
                    </tr>
                    <tr>
                        <td>129</td>
                        <td>المشتريات</td>
                        <td>0.00</td>
                    </tr>
                    <tr>
                        <td>130</td>
                        <td>تغيير عملة</td>
                        <td>0.00</td>
                    </tr>
                    <tr>
                        <td>131</td>
                        <td>سلف موظفين</td>
                        <td>0.00</td>
                    </tr>
                    <tr>
                        <td>132</td>
                        <td>عهد الموظفين</td>
                        <td>0.00</td>
                    </tr>
                    <tr class="table-info">
                        <td colspan="2" class="text-end"><strong>مجموع الأصول</strong></td>
                        <td><strong>0.00 ر.س</strong></td>
                    </tr>
                </tbody>
            </table>

            <!-- جدول الخصوم -->
            <h5 class="mt-4">الخصوم</h5>
            <table class="table table-bordered">
                <thead class="table-danger">
                    <tr>
                        <th>رقم الحساب</th>
                        <th>اسم الحساب</th>
                        <th>المبلغ (ر.س)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>21</td>
                        <td>رأس المال وحقوق الملكية</td>
                        <td>0.00</td>
                    </tr>
                    <tr>
                        <td>22</td>
                        <td>الخصوم المتداولة</td>
                        <td>0.00</td>
                    </tr>
                    <tr>
                        <td colspan="3" class="text-center"><strong>تفاصيل الخصوم المتداولة</strong></td>
                    </tr>
                    <tr>
                        <td>221</td>
                        <td>أوراق الدفع</td>
                        <td>0.00</td>
                    </tr>
                    <tr>
                        <td>222</td>
                        <td>الدائنون</td>
                        <td>0.00</td>
                    </tr>
                    <tr>
                        <td>2221</td>
                        <td>الموردون</td>
                        <td>0.00</td>
                    </tr>
                    <tr>
                        <td>2222</td>
                        <td>أطراف دائنة أخرى</td>
                        <td>0.00</td>
                    </tr>
                    <tr>
                        <td>2223</td>
                        <td>ضريبة القيمة المضافة 15%</td>
                        <td>0.00</td>
                    </tr>
                    <tr>
                        <td>224</td>
                        <td>مجمع الإهلاك</td>
                        <td>0.00</td>
                    </tr>
                    <tr>
                        <td>225</td>
                        <td>القيمة المضافة المطلوبة</td>
                        <td>0.00</td>
                    </tr>
                    <tr>
                        <td>226</td>
                        <td>صفرية المطلوبة</td>
                        <td>0.00</td>
                    </tr>
                    <tr>
                        <td>227</td>
                        <td>قيمة مضافة المطلوبة</td>
                        <td>0.00</td>
                    </tr>
                    <tr>
                        <td>23</td>
                        <td>ضرائب محصلة من الغير</td>
                        <td>0.00</td>
                    </tr>
                    <tr>
                        <td>24</td>
                        <td>شحن</td>
                        <td>0.00</td>
                    </tr>
                    <tr>
                        <td>25</td>
                        <td>أرباح / خسائر رأسمالية</td>
                        <td>0.00</td>
                    </tr>
                    <tr class="table-info">
                        <td colspan="2" class="text-end"><strong>مجموع الخصوم</strong></td>
                        <td><strong>0.00 ر.س</strong></td>
                    </tr>
                </tbody>
            </table>

            <!-- مجموع الميزانية -->
            <h5 class="mt-4 text-center"><strong>أرباح / خسائر رأسمالية (غير مرحلة): 0.00 ر.س</strong></h5>
        </div>
    </div>
</div>




    @endsection
