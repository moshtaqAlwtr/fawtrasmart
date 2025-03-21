@extends('master')

@section('title')
الشيكات المستلمة
@stop

@section('content')

<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-left mb-0">الشيكات المستلمة</h2>
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

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-4">
    <div class="card">
        <div class="card-body">
            <form>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label for="accountReceiver" class="form-label">الحساب المستلم</label>
                        <input type="text" class="form-control" id="accountReceiver" placeholder="الكل">
                    </div>
                    <div class="col-md-4">
                        <label for="bankName" class="form-label">اسم البنك</label>
                        <select class="form-control" id="bankName">
                            <option>اختر البنك</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="issueFromDate" class="form-label">الإصدار من تاريخ</label>
                        <input type="date" class="form-control" id="issueFromDate">
                    </div>
                    <div class="col-md-4">
                        <label for="issueToDate" class="form-label">الإصدار إلى تاريخ</label>
                        <input type="date" class="form-control" id="issueToDate">
                    </div>
                    <div class="col-md-4">
                        <label for="dueFromDate" class="form-label">تاريخ الاستحقاق من</label>
                        <input type="date" class="form-control" id="dueFromDate">
                    </div>
                    <div class="col-md-4">
                        <label for="dueToDate" class="form-label">تاريخ الاستحقاق إلى</label>
                        <input type="date" class="form-control" id="dueToDate">
                    </div>
                    <div class="col-md-4">
                        <label for="status" class="form-label">الحالة</label>
                        <select class="form-control" id="status">
                            <option>اختر الحالة</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="groupBy" class="form-label">تجميع حسب</label>
                        <select class="form-control" id="groupBy">
                            <option>رقم دفتر الشيكات</option>
                        </select>
                    </div>
                    <div class="col-md-12 text-end">
                        <button type="submit" class="btn btn-primary">عرض التقرير</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection