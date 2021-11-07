<header class="topbar" data-navbarbg="skin5">
    <nav class="navbar top-navbar navbar-expand-md navbar-dark">
      <div class="navbar-header" data-logobg="skin5">
        <!-- ============================================================== -->
        <!-- Logo -->
        <!-- ============================================================== -->
        <a class="navbar-brand" href="{{ asset('dashboard')}}">
          <!-- Logo icon -->
          <b class="logo-icon ps-0">
            <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
            <!-- Dark Logo icon -->
            @php  $setup_data =  App\Models\OrganizationSetup::first(); @endphp
            {{-- <img src="{{ asset('')}}assets/images/logo-icon.png" alt="homepage" class="light-logo" width="25"/> --}}
          </b>
          <!--End Logo icon -->
          <!-- Logo text -->
          <span class="logo-text ms-2">
            <!-- dark Logo text -->
            @if(isset($setup_data))
            <img src="{{ asset('')}}public/assets/images/{{$setup_data->templete_logo}}" alt="Logo" class="light-logo AdminLogo"/>
            @else
            <img src="{{ asset('')}}public/assets/images/logo-text.png" alt="Logo" class="light-logo"/>
            @endif
            
          </span>
          <!-- Logo icon -->
          <!-- <b class="logo-icon"> -->
          <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
          <!-- Dark Logo icon -->
          <!-- <img src="../assets/images/logo-text.png" alt="homepage" class="light-logo" /> -->

          <!-- </b> -->
          <!--End Logo icon -->
        </a>
        <!-- ============================================================== -->
        <!-- End Logo -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Toggle which is visible on mobile only -->
        <!-- ============================================================== -->
        <a
          class="nav-toggler waves-effect waves-light d-block d-md-none"
          href="javascript:void(0)"
          ><i class="ti-menu ti-close"></i
        ></a>
      </div>
      <!-- ============================================================== -->
      <!-- End Logo -->
      <!-- ============================================================== -->
      <div
        class="navbar-collapse collapse"
        id="navbarSupportedContent"
        data-navbarbg="skin5">
        <!-- ============================================================== -->
        <!-- toggle and nav items -->
        <!-- ============================================================== -->
        <ul class="navbar-nav float-start me-auto">
          <li class="nav-item d-none d-lg-block">
            <a
              class="nav-link sidebartoggler waves-effect waves-light"
              href="javascript:void(0)"
              data-sidebartype="mini-sidebar"
              ><i class="mdi mdi-menu font-24"></i
            ></a>
          </li>
        </ul>
        <!-- ============================================================== -->
        <!-- Right side toggle and nav items -->
        <!-- ============================================================== -->
        <ul class="navbar-nav float-end">
          <!-- ============================================================== -->
          <!-- Comment -->
          <!-- ============================================================== -->
          <li class="nav-item dropdown">
            <a
              class="nav-link dropdown-toggle"
              href="#"
              id="navbarDropdown"
              role="button"
              data-bs-toggle="dropdown"
              aria-expanded="false"
            >
              <i class="mdi mdi-bell font-24"></i>
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
              <li><a class="dropdown-item" href="#">Action</a></li>
              <li><a class="dropdown-item" href="#">Another action</a></li>
              <li><hr class="dropdown-divider" /></li>
              <li>
                <a class="dropdown-item" href="#">Something else here</a>
              </li>
            </ul>
          </li>
          <!-- ============================================================== -->
          <!-- End Comment -->
          <!-- ============================================================== -->
          <!-- ============================================================== -->
    
          <!-- ============================================================== -->
          <!-- User profile and search -->
          <!-- ============================================================== -->
          <li class="nav-item dropdown">
            <a
              class="
                nav-link
                dropdown-toggle
                text-muted
                waves-effect waves-dark
                pro-pic
              "
              href="#"
              id="navbarDropdown"
              role="button"
              data-bs-toggle="dropdown"
              aria-expanded="false"
            >
              <img
                src="public/assets/images/users/1.jpg"
                alt="user"
                class="rounded-circle"
                width="31"
              />
            </a>
            <ul
              class="dropdown-menu dropdown-menu-end user-dd animated"
              aria-labelledby="navbarDropdown"
            >
              <a class="dropdown-item" href="javascript:void(0)"
                ><i class="mdi mdi-account me-1 ms-1"></i> My Profile</a
              >
              <a class="dropdown-item" href="javascript:void(0)"
                ><i class="mdi mdi-wallet me-1 ms-1"></i> My Balance</a
              >
              <a class="dropdown-item" href="javascript:void(0)"
                ><i class="mdi mdi-email me-1 ms-1"></i> Inbox</a
              >
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="javascript:void(0)"
                ><i class="mdi mdi-settings me-1 ms-1"></i> Account
                Setting</a
              >
              <div class="dropdown-divider"></div>
              <a class="dropdown-item"  href="{{ route('logout') }}"
              onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();"
                ><i class="fa fa-power-off me-1 ms-1"></i> {{ __('Logout') }}</a
              >
              <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
              <div class="dropdown-divider"></div>
              <div class="ps-4 p-10">
                <a
                  href="javascript:void(0)"
                  class="btn btn-sm btn-success btn-rounded text-white"
                  >View Profile</a
                >
              </div>
            </ul>
          </li>
          <!-- ============================================================== -->
          <!-- User profile and search -->
          <!-- ============================================================== -->
        </ul>
      </div>
    </nav>
  </header>