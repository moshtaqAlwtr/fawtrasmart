@extends('master')

@section('title')
تقرير الربح والخسارة
@stop


@section('content')




<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-left mb-0">تقرير الربح والخساره(تقديري)</h2>
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


<div class="cart mt-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white text-center">
            <h4>الجدول المالي السنوي</h4>
        </div>
        <div class="card-body">
            <table class="table table-bordered text-center">
                <thead class="table-light">
                    <tr>
                        <th>الحساب</th>
                        <th>Dec 2023</th>
                        <th>Jan 2024</th>
                        <th>Feb 2024</th>
                        <th>Mar 2024</th>
                        <th>Apr 2024</th>
                        <th>May 2024</th>
                        <th>Jun 2024</th>
                        <th>Jul 2024</th>
                        <th>Aug 2024</th>
                        <th>Sep 2024</th>
                        <th>Oct 2024</th>
                        <th>Nov 2024</th>
                        <th>Dec 2024</th>
                        <th>الإجمالي</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- المبيعات (الفواتير) -->
                    <tr>
                        <td>المبيعات (الفواتير)</td>
                        <td>27,162 ر.س</td>
                        <td>59,877 ر.س</td>
                        <td>69,254 ر.س</td>
                        <td>82,381.68 ر.س</td>
                        <td>54,315 ر.س</td>
                        <td>77,563 ر.س</td>
                        <td>57,038.84 ر.س</td>
                        <td>71,026 ر.س</td>
                        <td>45,408 ر.س</td>
                        <td>43,432 ر.س</td>
                        <td>31,248 ر.س</td>
                        <td>26,090 ر.س</td>
                        <td>10,101 ر.س</td>
                        <td>654,896.52 ر.س</td>
                    </tr>
                    <!-- رصيد مدفوعات العميل -->
                    <tr>
                        <td>رصيد مدفوعات العميل</td>
                        <td>19,940 ر.س</td>
                        <td>42,274 ر.س</td>
                        <td>50,102 ر.س</td>
                        <td>49,464 ر.س</td>
                        <td>40,094 ر.س</td>
                        <td>56,179 ر.س</td>
                        <td>41,252 ر.س</td>
                        <td>50,657 ر.س</td>
                        <td>40,339 ر.س</td>
                        <td>35,994 ر.س</td>
                        <td>30,910 ر.س</td>
                        <td>42,345 ر.س</td>
                        <td>19,189 ر.س</td>
                        <td>518,739 ر.س</td>
                    </tr>
                    <!-- إجمالي الإيراد -->
                    <tr>
                        <td>إجمالي الإيراد</td>
                        <td>47,102 ر.س</td>
                        <td>102,151 ر.س</td>
                        <td>119,356 ر.س</td>
                        <td>131,845.68 ر.س</td>
                        <td>94,409 ر.س</td>
                        <td>133,742 ر.س</td>
                        <td>98,290.84 ر.س</td>
                        <td>121,683 ر.س</td>
                        <td>85,747 ر.س</td>
                        <td>79,426 ر.س</td>
                        <td>62,158 ر.س</td>
                        <td>68,435 ر.س</td>
                        <td>29,290 ر.س</td>
                        <td>1,173,635.52 ر.س</td>
                    </tr>
                    <!-- الفواتير المرتجعة -->
                    <tr>
                        <td>الفواتير المرتجعة</td>
                        <td>0.00 ر.س</td>
                        <td>432.00 ر.س</td>
                        <td>1,596 ر.س</td>
                        <td>1,507.68 ر.س</td>
                        <td>1,323 ر.س</td>
                        <td>1,530 ر.س</td>
                        <td>339.84 ر.س</td>
                        <td>0.00 ر.س</td>
                        <td>1,242 ر.س</td>
                        <td>1,242 ر.س</td>
                        <td>540.00 ر.س</td>
                        <td>1,134 ر.س</td>
                        <td>432.00 ر.س</td>
                        <td>11,318.52 ر.س</td>
                    </tr>
                    <!-- فواتير الشراء -->
                    <tr>
                        <td>فواتير الشراء</td>
                        <td>0.00 ر.س</td>
                        <td>0.00 ر.س</td>
                        <td>0.00 ر.س</td>
                        <td>0.00 ر.س</td>
                        <td>0.00 ر.س</td>
                        <td>0.00 ر.س</td>
                        <td>0.00 ر.س</td>
                        <td>0.00 ر.س</td>
                        <td>0.00 ر.س</td>
                        <td>0.00 ر.س</td>
                        <td>0.00 ر.س</td>
                        <td>0.00 ر.س</td>
                        <td>0.00 ر.س</td>
                    </tr>
                    <!-- مصروفات اخرى -->
                    <tr>
                        <td>مصروفات اخرى</td>
                        <td>0.00 ر.س</td>
                        <td>0.00 ر.س</td>
                        <td>0.00 ر.س</td>
                        <td>0.00 ر.س</td>
                        <td>0.00 ر.س</td>
                        <td>0.00 ر.س</td>
                        <td>0.00 ر.س</td>
                        <td>0.00 ر.س</td>
                        <td>0.00 ر.س</td>
                        <td>0.00 ر.س</td>
                        <td>79.00 ر.س</td>
                        <td>0.00 ر.س</td>
                        <td>79.00 ر.س</td>
                    </tr>
                    <!-- إجمالي المصروفات -->
                    <tr>
                        <td>إجمالي المصروفات</td>
                        <td>0.00 ر.س</td>
                        <td>432.00 ر.س</td>
                        <td>1,596 ر.س</td>
                        <td>1,507.68 ر.س</td>
                        <td>1,323 ر.س</td>
                        <td>1,530 ر.س</td>
                        <td>339.84 ر.س</td>
                        <td>0.00 ر.س</td>
                        <td>1,242 ر.س</td>
                        <td>1,242 ر.س</td>
                        <td>540.00 ر.س</td>
                        <td>1,213 ر.س</td>
                        <td>432.00 ر.س</td>
                        <td>11,397.52 ر.س</td>
                    </tr>
                    <!-- الربح -->
                    <tr>
                        <td>الربح</td>
                        <td>47,102 ر.س</td>
                        <td>101,719 ر.س</td>
                        <td>117,760 ر.س</td>
                        <td>130,338 ر.س</td>
                        <td>93,086 ر.س</td>
                        <td>132,212 ر.س</td>
                        <td>97,951 ر.س</td>
                        <td>121,683 ر.س</td>
                        <td>84,505 ر.س</td>
                        <td>78,184 ر.س</td>
                        <td>61,618 ر.س</td>
                        <td>67,222 ر.س</td>
                        <td>28,858 ر.س</td>
                        <td>1,162,238 ر.س</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>




    @endsection
