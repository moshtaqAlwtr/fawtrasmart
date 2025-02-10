@extends('master')

@section('title')
أضف حجز
@stop

@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-left mb-0">أضف حجز</h2>
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


<div class="container my-5">

    <!-- Alert Message -->
    <div class="alert alert-danger d-flex justify-content-between align-items-center" role="alert">
        <span>يجب أن يكون لديك خدمة نشطة واحدة على الأقل وتأكد من إدخال المدة لإكمال الحجز</span>
        <button class="btn btn-success" onclick="window.location.href='add_service.html'">أضف خدمة</button>
    </div>


</div>


<!-- BEGIN: Vendor CSS-->
<link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/vendors.min.css')}}">
<!-- END: Vendor CSS-->

<!-- BEGIN: Theme CSS-->


<!-- BEGIN: Page CSS-->
<link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/core/menu/menu-types/vertical-menu.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/core/colors/palette-gradient.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/plugins/forms/wizard.css')}}">

<!-- END: Header-->


<!-- BEGIN: Main Menu-->

<!-- END: Main Menu-->

<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">Form Wizard</h2>
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html">Home</a>
                                </li>
                                <li class="breadcrumb-item"><a href="#">Forms</a>
                                </li>
                                <li class="breadcrumb-item active">Form Wizard
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-header-right text-md-right col-md-3 col-12 d-md-block d-none">
                <div class="form-group breadcrum-right">
                    <div class="dropdown">
                        <button class="btn-icon btn btn-primary btn-round btn-sm dropdown-toggle" type="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
                                class="feather icon-settings"></i></button>
                        <div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="#">Chat</a><a
                                class="dropdown-item" href="#">Email</a><a class="dropdown-item" href="#">Calendar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <!-- Form wizard with number tabs section start -->
            <section id="number-tabs">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Form wizard with number tabs</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <p>Create neat and clean form wizard using <code>.wizard-circle</code> class.</p>
                                    <form action="#" class="number-tab-steps wizard-circle">

                                        <!-- Step 1 -->
                                        <h6>خدمة </h6>
                                        <fieldset>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="firstName1">خدمة </label>
                                                        <input type="text" class="form-control" id="firstName1">
                                                    </div>
                                                </div>

                                             
                                            </div>

                                            <div class="row">
                                           
                                            </div>
                                        </fieldset>

                                        <!-- Step 2 -->
                                        <h6>موظف </h6>
                                        <fieldset>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="proposalTitle1">أختر الموظف</label>
                                                        <input type="text" class="form-control" id="proposalTitle1">
                                                    </div>
                                                
                                                </div>
                                               
                                            </div>
                                        </fieldset>

                                        <!-- Step 3 -->
                                        <h6>التاريخ </h6>
                                        <fieldset>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="eventName1">Event Name :</label>
                                                        <input type="text" class="form-control" id="eventName1">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="eventType1">Event Status :</label>
                                                        <select class="custom-select form-control" id="eventType1"
                                                            data-placeholder="Type to search cities" name="eventType1">
                                                            <option value="Banquet">Planning</option>
                                                            <option value="Fund Raiser">In Process</option>
                                                            <option value="Dinner Party">Finished</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <!-- Step 4 -->
                                                <h6>العميل </h6>
                                                <fieldset>
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label for="eventName1">Event Name :</label>
                                                                <input type="text" class="form-control" id="eventName1">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="eventType1">Event Status :</label>
                                                                <select class="custom-select form-control"
                                                                    id="eventType1"
                                                                    data-placeholder="Type to search cities"
                                                                    name="eventType1">
                                                                    <option value="Banquet">Planning</option>
                                                                    <option value="Fund Raiser">In Process</option>
                                                                    <option value="Dinner Party">Finished</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label for="eventLocation1">Event Location :</label>
                                                                <select class="custom-select form-control"
                                                                    id="eventLocation1" name="location">
                                                                    <option value="new-york">New York</option>
                                                                    <option value="chicago">Chicago</option>
                                                                    <option value="san-francisco">San Francisco</option>
                                                                    <option value="boston">Boston</option>
                                                                </select>
                                                            </div>
                                                            <div class="form-group d-flex align-items-center pt-md-2">
                                                                <label class="mr-2">Requirements :</label>
                                                                <div class="c-inputs-stacked">
                                                                    <div class="d-inline-block mr-2">
                                                                        <div
                                                                            class="vs-checkbox-con vs-checkbox-primary">
                                                                            <input type="checkbox" value="false">
                                                                            <span class="vs-checkbox">
                                                                                <span class="vs-checkbox--check">
                                                                                    <i
                                                                                        class="vs-icon feather icon-check"></i>
                                                                                </span>
                                                                            </span>
                                                                            <span class="">Staffing</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="d-inline-block">
                                                                        <div
                                                                            class="vs-checkbox-con vs-checkbox-primary">
                                                                            <input type="checkbox" value="false">
                                                                            <span class="vs-checkbox">
                                                                                <span class="vs-checkbox--check">
                                                                                    <i
                                                                                        class="vs-icon feather icon-check"></i>
                                                                                </span>
                                                                            </span>
                                                                            <span class="">Catering</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Form wizard with step validation section end -->

        </div>
    </div>
</div>
<!-- END: Content-->

<div class="sidenav-overlay"></div>
<div class="drag-target"></div>

<!-- BEGIN: Footer-->
<footer class="footer footer-static footer-light">
    <p class="clearfix blue-grey lighten-2 mb-0"><span class="float-md-left d-block d-md-inline-block mt-25">COPYRIGHT
            &copy; 2020<a class="text-bold-800 grey darken-2" href="https://1.envato.market/pixinvent_portfolio"
                target="_blank">Pixinvent,</a>All rights Reserved</span><span
            class="float-md-right d-none d-md-block">Hand-crafted & Made with<i
                class="feather icon-heart pink"></i></span>
        <button class="btn btn-primary btn-icon scroll-top" type="button"><i class="feather icon-arrow-up"></i></button>
    </p>
</footer>
<!-- END: Footer-->


<!-- BEGIN: Vendor JS-->
<script src="{{asset('app-assets/vendors/js/vendors.min.js')}}"></script>
<!-- BEGIN Vendor JS-->

<!-- BEGIN: Page Vendor JS-->
<script src="{{asset('app-assets/vendors/js/extensions/jquery.steps.min.js')}}"></script>
<script src="{{asset('app-assets/vendors/js/forms/validation/jquery.validate.min.js')}}"></script>
<!-- END: Page Vendor JS-->

<!-- BEGIN: Theme JS-->
<script src="{{asset('app-assets/js/core/app-menu.js')}}"></script>
<script src="{{asset('app-assets/js/core/app.js')}}"></script>
<script src="{{asset('app-assets/js/scripts/components.js')}}"></script>
<!-- END: Theme JS-->

<!-- BEGIN: Page JS-->
<script src="{{asset('app-assets/js/scripts/forms/wizard-steps.js')}}"></script>
<!-- END: Page JS-->

</body>
<!-- END: Body-->

</html>
@endsection