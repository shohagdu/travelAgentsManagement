<aside class="left-sidebar" data-sidebarbg="skin5">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
      <!-- Sidebar navigation-->
      <nav class="sidebar-nav">
        <ul id="sidebarnav" class="pt-4">
          <li class="sidebar-item">
            <a
              class="sidebar-link waves-effect waves-dark sidebar-link"
              href="{{asset('/dashboard')}}"
              aria-expanded="false"
              ><i class="mdi mdi-view-dashboard"></i
              ><span class="hide-menu">Dashboard</span></a>
          </li>
          <li class="sidebar-item">
            <a
              class="sidebar-link has-arrow waves-effect waves-dark"
              href="javascript:void(0)"
              aria-expanded="false"
              ><i class="mdi mdi-cart"></i
              ><span class="hide-menu"> Sale </span></a>
            <ul aria-expanded="false" class="collapse first-level">
              <li class="sidebar-item">
                <a href="{{ route('sale')}}" class="sidebar-link"
                  ><i class="mdi mdi-note-outline"></i
                  ><span class="hide-menu"> Sale </span></a>
              </li>
              <li class="sidebar-item">
                <a href="{{ route('sale-list')}}" class="sidebar-link"
                  ><i class="mdi mdi-note-outline"></i
                  ><span class="hide-menu">  Sale List </span></a>
              </li>
            </ul>
          </li>
          <li class="sidebar-item">
            <a
              class="sidebar-link has-arrow waves-effect waves-dark"
              href="javascript:void(0)"
              aria-expanded="false"
              ><i class="mdi mdi-receipt"></i
              ><span class="hide-menu">Agent Record </span></a>
            <ul aria-expanded="false" class="collapse first-level">
              <li class="sidebar-item">
                <a href="{{ route('add-agent')}}" class="sidebar-link"
                  ><i class="mdi mdi-note-outline"></i
                  ><span class="hide-menu"> Add Agent </span></a>
              </li>
              <li class="sidebar-item">
                <a href="{{ route('agent-list')}}" class="sidebar-link"
                  ><i class="mdi mdi-note-outline"></i
                  ><span class="hide-menu">  Agent List </span></a>
              </li>
            </ul>
          </li>
          <li class="sidebar-item">
            <a class="sidebar-link has-arrow waves-effect waves-dark"
              href="javascript:void(0)"
              aria-expanded="false"
              ><i class="mdi mdi-relative-scale"></i
              ><span class="hide-menu">Airline Setup </span></a>
            <ul aria-expanded="false" class="collapse first-level">
              <li class="sidebar-item">
                <a href="{{ route('airline-setup')}}" class="sidebar-link"
                  ><i class="mdi mdi-note-outline"></i
                  ><span class="hide-menu"> Add Airline Setup </span></a>
              </li>
              <li class="sidebar-item">
                <a href="{{ route('airline-setup-list')}}" class="sidebar-link"
                  ><i class="mdi mdi-note-outline"></i
                  ><span class="hide-menu">  Airline Setup  List </span></a>
              </li>
            </ul>
          </li>
          <li class="sidebar-item">
            <a class="sidebar-link has-arrow waves-effect waves-dark"
              href="javascript:void(0)"
              aria-expanded="false"
              ><i class="mdi mdi-pencil"></i
              ><span class="hide-menu">Country Setup </span></a>
            <ul aria-expanded="false" class="collapse first-level">
              <li class="sidebar-item">
                <a href="{{ route('country-setup')}}" class="sidebar-link"
                  ><i class="mdi mdi-note-outline"></i
                  ><span class="hide-menu"> Add Country Setup </span></a>
              </li>
              <li class="sidebar-item">
                <a href="{{ route('country-setup-list')}}" class="sidebar-link"
                  ><i class="mdi mdi-note-outline"></i
                  ><span class="hide-menu">  Country Setup  List </span></a>
              </li>
            </ul>
          </li>
          <li class="sidebar-item">
            <a class="sidebar-link has-arrow waves-effect waves-dark"
              href="javascript:void(0)"
              aria-expanded="false"
              ><i class="mdi mdi-format-list-bulleted-type"></i
              ><span class="hide-menu">Sale Category </span></a>
            <ul aria-expanded="false" class="collapse first-level">
              <li class="sidebar-item">
                <a href="{{ route('sale-category')}}" class="sidebar-link"
                  ><i class="mdi mdi-note-outline"></i
                  ><span class="hide-menu"> Add Sale Category </span></a>
              </li>
              <li class="sidebar-item">
                <a href="{{ route('sale-category-list')}}" class="sidebar-link"
                  ><i class="mdi mdi-note-outline"></i
                  ><span class="hide-menu"> Sale Category  List </span></a>
              </li>
            </ul>
          </li>
          <li class="sidebar-item">
            <a class="sidebar-link has-arrow waves-effect waves-dark"
              href="javascript:void(0)"
              aria-expanded="false"
              ><i class="mdi mdi-image-filter-vintage"></i
              ><span class="hide-menu">Setting </span></a>
            <ul aria-expanded="false" class="collapse first-level">
              <li class="sidebar-item">
                <a href="{{ route('organization-setup')}}" class="sidebar-link"
                  ><i class="mdi mdi-note-outline"></i
                  ><span class="hide-menu"> Organization Setup </span></a>
              </li>
            </ul>
          </li>
          <li class="sidebar-item">
            <a
              class="sidebar-link has-arrow waves-effect waves-dark"
              href="javascript:void(0)"
              aria-expanded="false"
              ><i class="mdi mdi-account-box"></i
              ><span class="hide-menu">User </span></a
            >
            <ul aria-expanded="false" class="collapse first-level">
              <li class="sidebar-item">
                <a href="{{ route('add-user') }}" class="sidebar-link"
                  ><i class="mdi mdi-account-plus"></i
                  ><span class="hide-menu"> Add User </span></a
                >
              </li>
              <li class="sidebar-item">
                <a href="{{  asset('user-list')}}" class="sidebar-link"
                  ><i class="mdi mdi-account-card-details"></i
                  ><span class="hide-menu"> User List </span></a
                >
              </li>
            </ul>
          </li>
        </ul>
      </nav>
      <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
  </aside>