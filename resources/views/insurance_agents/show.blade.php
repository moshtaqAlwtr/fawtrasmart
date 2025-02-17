@extends('master')

@section('title')
    عرض وكلاء التامين
@stop

@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">عرض وكيل تأمين</h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="">الرئيسية</a></li>
                            <li class="breadcrumb-item active">عرض</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="col-md-12 mx-auto">
        <div class="card">
            <div class="card-body">
                <div class="row" id="client-additional-data">
                    <div class="col-md-6">
                        <div class="client-profile">
                            <h3 class="media-heading">{{ $insuranceAgent->name }}</h3>
                            <h4 class="text-muted">#{{ $insuranceAgent->id }}</h4>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <td class="text-end">
                                        <a href="mailto:{{ $insuranceAgent->email }}" class="btn btn-outline-primary btn-block">
                                            <i class="fa fa-envelope"></i> {{ $insuranceAgent->email }}
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-end">
                                        <a href="tel:{{ $insuranceAgent->phone }}" class="btn btn-outline-success btn-block">
                                            <i class="fa fa-phone"></i> {{ $insuranceAgent->phone }}
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div



@endsection
