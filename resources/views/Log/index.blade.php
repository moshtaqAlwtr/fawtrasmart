
@extends('master')

@section('title')
المنتجات
@stop

@section('css')
<style>
    .user-avatar {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background-color: #007bff; /* لون الخلفية */
        color: #fff; /* لون النص */
        font-weight: bold;
        font-size: 14px;
    }
</style>
@endsection

@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">سجل نشاطات النظام</h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="">الرئيسيه</a>
                            </li>
                           
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.alerts.success')
    @include('layouts.alerts.error')

    <div class="content-body">
     

        <div class="container" style="max-width: 1200px">
            <div class="card">
               
                <div class="card-body">
                    <ul class="nav nav-tabs" role="tablist">
                      
                       
                        <li class="nav-item">
                            <a class="nav-link" id="about-tab" data-toggle="tab" href="#about" aria-controls="about" role="tab" aria-selected="true">الجدول الزمني</a>
                        </li>
                      

                    </ul>

                    <div class="tab-content">

                        <div class="tab-pane active" id="home" aria-labelledby="home-tab" role="tabpanel">
                            <div class="row">

                              
                            </div>

                           
                        </div>


                        <div class="tab-pane" id="about" aria-labelledby="about-tab" role="tabpanel">
                            <div class="card">
                                <div class="card-content">
                                    <div class="card-body">
                                        @if(isset($logs) && !empty($logs) && count($logs) > 0)
                                            <ul class="activity-timeline timeline-left list-unstyled">
                                                @foreach($logs as $log)
                                                    <li>
                                                        <div class="timeline-icon bg-success">
                                                            <i class="feather icon-package font-medium-2"></i>
                                                        </div>
                                                        <div class="timeline-info">
                                                            <p>
                                                               
                                                                {!! Str::markdown($log->description) !!}
                                                            </p>
                                                            <br>
                                                            <span>
                                                                <i class="fa fa-clock-o"></i> {{$log->created_at ?? ""}} - <span class="tip observed tooltipstered" data-title=""> <i class="fa fa-user"></i>{{$log->user->name ?? ""}} </span> - <i class="fa fa-building"> {{$log->user->branch->name ?? ""}}</i> 
                                                            </span>
                                                        </div>
                                                    </li>
                                                    <hr>
                                                @endforeach
                                            </ul>
                                        @else
                                            <div class="alert alert-danger text-xl-center" role="alert">
                                                <p class="mb-0">
                                                    لا توجد عمليات مضافه حتى الان !!
                                                </p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                    
                    </div>
                </div>
            </div>
        </div>


        <!-- Modal delete -->
    
        <!--end delete-->

    </div>

@endsection

@section('scripts')

<script>
    function remove_disabled() {
        if (document.getElementById("ProductTrackStock").checked) {
            disableForm(false);
        }
        if (!document.getElementById("ProductTrackStock").checked) {
            disableForm(true);
        }
    }

    function disableForm(flag) {
        var elements = document.getElementsByClassName("ProductTrackingInput");
        for (var i = 0, len = elements.length; i < len; ++i) {
            elements[i].readOnly = flag;
            elements[i].disabled = flag;
        }
    }
</script>
<!----------------------------------------------->
<script>
    function remove_disabled_ckeckbox() {
        if(document.getElementById("available_online").checked)
            document.getElementById("featured_product").disabled = false;
        else
        document.getElementById("featured_product").disabled = true;
    }
</script>

@endsection
