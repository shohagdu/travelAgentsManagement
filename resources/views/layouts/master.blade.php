<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="path" content="{{ url('/') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="keywords"  content="Travel Agency Management System" />
    <meta  name="description" content="Travel Agency Management System"
    />
    <meta name="robots" content="noindex,nofollow"/>
    <title> @yield('title') </title>
    @php  $setup_data =  App\Models\OrganizationSetup::first(); @endphp
        @if(isset($setup_data))
            <link
                rel="icon"
                type="image/png"
                sizes="16x16"
                href="{{ asset('')}}public/assets/images/{{$setup_data->favicon}}"
            />
        @else
            <link
                rel="icon"
                type="image/png"
                sizes="16x16"
                href="{{ asset('')}}public/assets/images/favicon.png"
            />
    @endif
    <!-- Custom CSS -->
        <link href="{{ asset('public/assets/libs/flot/css/float-chart.css')}}" rel="stylesheet"/>
        <!-- Custom CSS -->
        <link href="{{ asset('public/dist/css/style.min.css')}}" rel="stylesheet"/>
        <link href="{{ asset('public/css/customs.css')}}" rel="stylesheet"/>
    @yield('css')
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
<div class="preloader">
    <div class="lds-ripple">
        <div class="lds-pos"></div>
        <div class="lds-pos"></div>
    </div>
</div>
<div  id="main-wrapper"
    data-layout="vertical"
    data-navbarbg="skin5"
    data-sidebartype="full"
    data-sidebar-position="absolute"
    data-header-position="absolute"
    data-boxed-layout="full">

    @include('layouts.include.header')
    @include('layouts.include.left_menu')
    <div class="page-wrapper">
        @yield('breadcrumb')
        <div class="container-fluid" style="min-height: 550px">
            @yield('main_content')
        </div>
        @include('layouts.include.footer')
    </div>
</div>
<script src="{{ asset('public/assets/libs/jquery/dist/jquery.min.js')}}"></script>
<!-- Bootstrap tether Core JavaScript -->
<script src="{{ asset('public/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{ asset('public/assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js')}}"></script>
<script src="{{ asset('public/assets/extra-libs/sparkline/sparkline.js')}}"></script>
<!--Wave Effects -->
<script src="{{ asset('public/dist/js/waves.js')}}"></script>
<!--Menu sidebar -->
<script src="{{ asset('public/dist/js/sidebarmenu.js')}}"></script>
<!--Custom JavaScript -->
<script src="{{ asset('public/dist/js/custom.min.js')}}"></script>
<!--This page JavaScript -->
<!-- <script src="../dist/js/pages/dashboards/dashboard1.js"></script> -->
<!-- Charts js Files -->
<script src="{{ asset('public/assets/libs/flot/excanvas.js')}}"></script>
<script src="{{ asset('public/assets/libs/flot/jquery.flot.js')}}"></script>
<script src="{{ asset('public/assets/libs/flot/jquery.flot.pie.js')}}"></script>
<script src="{{ asset('public/assets/libs/flot/jquery.flot.time.js')}}"></script>
<script src="{{ asset('public/assets/libs/flot/jquery.flot.stack.js')}}"></script>
<script src="{{ asset('public/assets/libs/flot/jquery.flot.crosshair.js')}}"></script>
<script src="{{ asset('public/assets/libs/flot.tooltip/js/jquery.flot.tooltip.min.js')}}"></script>
{{-- <script src="{{ asset('dist/js/pages/chart/chart-page-init.js')}}"></script> --}}
@yield('js')
</body>
</html>
