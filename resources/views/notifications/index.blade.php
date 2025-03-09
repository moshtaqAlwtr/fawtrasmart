@extends('master')

@section('title')
    أدارة الأشتراكات
@stop

@section('content')
    <div style="font-size: 1.1rem;">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0"> الأشعارات </h2>
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


            <div class="container mt-4">
              
        
                <div class="card p-3 mt-4">
                    <table class="table table-bordered text-center">
                        <thead class="table-light">
                            <tr>
                                <th>عنوان التنبيه</th>
                                <th>بيانات التنبيه</th>
                                <th>اجراءات</th>
                            
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($notifications as $notification)
                            <tr>
                              
                                    
                               
                                <td>{{$notification->title ?? ""}}</td>
                                <td>{{$notification->description ?? ""}}</td>
                                <td><a class="dropdown-item"
                                    href="{{ route('notifications.markAsReadid', $notification->id) }}">
                                    </i>اخفاء
                                </a></td>
                             
                            </tr>
                               @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
   
     
        
        @endsection