<!DOCTYPE html>
<html dir="ltr">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta
        name="keywords"
        content="Tripayan dashboard, html css dashboard, web dashboard, bootstrap 5 admin, bootstrap 5, css3 dashboard, bootstrap 5 dashboard, Matrix lite admin bootstrap 5 dashboard, frontend, responsive bootstrap 5 admin template, Matrix admin lite design, Matrix admin lite dashboard bootstrap 5 dashboard template"
    />
    <meta
        name="description"
        content="Tripayan Admin Lite Free Version is powerful and clean admin dashboard template, inpired from Bootstrap Framework"
    />
    <meta name="robots" content="noindex,nofollow"/>
    <title>Login - Global Travel Service</title>
@php  $setup_data =  App\Models\OrganizationSetup::first(); @endphp
<!-- Favicon icon -->
    @if(isset($setup_data))
        <link
            rel="icon"
            type="image/png"
            sizes="16x16"
            href="{{ asset('public/assets/images')}}/{{$setup_data->favicon}}"
        />
    @else
        <link
            rel="icon"
            type="image/png"
            sizes="16x16"
            href="{{ asset('public/assets/images/favicon.png')}}"
        />
@endif
<!-- Custom CSS -->
    <link href="{{ asset('public/dist/css/style.min.css')}}" rel="stylesheet"/>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
</head>

<body>
<div >
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Login box.scss -->
    <!-- ============================================================== -->
    <div
        class="
          auth-wrapper
          d-flex
          no-block
          justify-content-center
          align-items-center

        "
        style="min-height: 100vh">
        <div class="auth-box ">
            <div id="loginform">
                <div class="text-center pt-3 pb-3">
              <span class="db"
              >
                @if(isset($setup_data))
                      <img src="{{ asset('public/assets/images')}}/{{$setup_data->logo}}" alt="logo"/>
                  @else
                      <img src="{{ asset('public/assets/images/logo.png')}}" alt="logo"/>
                  @endif

              </span>
                </div>
                <!-- Form -->
                <form class="form-horizontal mt-3" autocomplete="off" id="loginform" method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="row pb-4">
                        <div class="col-12">
                            <div class="mb-3">
                                <input id="email" type="email"
                                       class="form-control form-control-lg @error('email') is-invalid @enderror"
                                       name="email"  value="{{ old('email') }}" placeholder="Email" required
                                       autocomplete="off" autofocus aria-describedby="basic-addon1">

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="input-group mb-3">
                                <input id="password" type="password"
                                       class="form-control  form-control-lg @error('password') is-invalid @enderror"
                                       name="password" required autocomplete="current-password" placeholder="Password"
                                       aria-describedby="basic-addon1" required>

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class=" border-top border-secondary">
                        <div class="col-12">
                            <div class="form-group">
                                <div class="pt-3">
                                    <button
                                        class="btn btn-success btn-lg btn-block text-white"
                                        type="submit"
                                    >
                                        Login
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div> 
</div>
<!-- ============================================================== -->
<!-- All Required js -->
<!-- ============================================================== -->
<script src="{{ asset('public/assets/libs/jquery/dist/jquery.min.js')}}"></script>
<!-- Bootstrap tether Core JavaScript -->
<script src="{{ asset('public/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
<!-- ============================================================== -->
<!-- This page plugin js -->
<!-- ============================================================== -->
<script>
    $(".preloader").fadeOut();
</script>
</body>
</html>
