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
                        ><span class="hide-menu"> Sales </span></a>
                    <ul aria-expanded="false" class="collapse first-level">
                        <li class="sidebar-item">
                            <a href="{{ route('sale')}}" class="sidebar-link"
                            ><i class="mdi mdi-note-outline"></i
                                ><span class="hide-menu"> New Sale </span></a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('today-sale-list')}}" class="sidebar-link"
                            ><i class="mdi mdi-note-outline"></i
                                ><span class="hide-menu"> Today All Sales Info </span></a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('sale-list')}}" class="sidebar-link"
                            ><i class="mdi mdi-note-outline"></i
                                ><span class="hide-menu"> View All Sales </span></a>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow waves-effect waves-dark"
                       href="javascript:void(0)"
                       aria-expanded="false"
                    ><i class="mdi mdi-book-open"></i
                        ><span class="hide-menu"> Account </span></a>
                    <ul aria-expanded="false" class="collapse first-level">
                        <li class="sidebar-item">
                            <a href="{{ route('bill-collection')}}" class="sidebar-link"
                            ><i class="mdi mdi-note-outline"></i
                                ><span class="hide-menu"> Credit Bill   </span></a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('debit-bill')}}" class="sidebar-link"
                            ><i class="mdi mdi-note-outline"></i
                                ><span class="hide-menu"> Debit Bill  </span></a>
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
                                ><span class="hide-menu"> Add New Agent </span></a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('agent-list')}}" class="sidebar-link"
                            ><i class="mdi mdi-note-outline"></i
                                ><span class="hide-menu"> View All Agent List </span></a>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-item">
                    <a
                        class="sidebar-link has-arrow waves-effect waves-dark"
                        href="javascript:void(0)"
                        aria-expanded="false"
                    ><i class="mdi mdi-book-open"></i
                        ><span class="hide-menu"> Reports </span></a>
                    <ul aria-expanded="false" class="collapse first-level">
                        <li class="sidebar-item">
                            <a href="{{ route('agent-date-wise-statement')}}" class="sidebar-link"
                            ><i class="mdi mdi-note-outline"></i
                                ><span class="hide-menu"> Agents  Statement </span>
                            </a>
                        </li>
{{--                        <li class="sidebar-item">--}}
{{--                            <a href="{{ route('account-report')}}" class="sidebar-link"--}}
{{--                            ><i class="mdi mdi-note-outline"></i--}}
{{--                                ><span class="hide-menu"> Account Report </span></a>--}}
{{--                        </li>--}}
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
                            <a href="{{ route('airline-setup')}}" class="sidebar-link"
                            ><i class="mdi mdi-note-outline"></i
                                ><span class="hide-menu"> Add New Airlines Setup </span></a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('airline-setup-list')}}" class="sidebar-link"
                            ><i class="mdi mdi-note-outline"></i
                                ><span class="hide-menu"> View All Airlines Setup </span></a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('sale-category')}}" class="sidebar-link"
                            ><i class="mdi mdi-note-outline"></i
                                ><span class="hide-menu"> Sale Category </span></a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('sale-category-list')}}" class="sidebar-link"
                            ><i class="mdi mdi-note-outline"></i
                                ><span class="hide-menu"> View All Sale Category </span></a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('towards-category')}}" class="sidebar-link"
                            ><i class="mdi mdi-note-outline"></i
                                ><span class="hide-menu"> Towards Category </span></a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('towards-category-list')}}" class="sidebar-link"
                            ><i class="mdi mdi-note-outline"></i
                                ><span class="hide-menu"> View All Towards Category </span></a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('bank-create')}}" class="sidebar-link"
                            ><i class="mdi mdi-note-outline"></i
                                ><span class="hide-menu"> Bank Setup </span></a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('bank-list')}}" class="sidebar-link"
                            ><i class="mdi mdi-note-outline"></i
                                ><span class="hide-menu"> Bank Details </span></a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('organization-setup')}}" class="sidebar-link"
                            ><i class="mdi mdi-note-outline"></i
                                ><span class="hide-menu"> Company  Configuration </span></a>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-item">
                    <a
                        class="sidebar-link has-arrow waves-effect waves-dark"
                        href="javascript:void(0)"
                        aria-expanded="false"
                    ><i class="mdi mdi-account-box"></i
                        ><span class="hide-menu">User Management</span></a>
                    <ul aria-expanded="false" class="collapse first-level">
                        <li class="sidebar-item">
                            <a href="{{ route('add-user') }}" class="sidebar-link"
                            ><i class="mdi mdi-account-plus"></i
                                ><span class="hide-menu"> Add New User </span></a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{  route('user-list')}}" class="sidebar-link"
                            ><i class="mdi mdi-account-card-details"></i
                                ><span class="hide-menu">View All User </span></a>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-item">
                    <a
                        class="sidebar-link waves-effect waves-dark sidebar-link"
                        href="{{ route('changePassword')}}"
                    ><i class="mdi mdi-settings me-1 ms-1"></i
                        ><span class="hide-menu">Change Password</span></a>
                </li>
                <li class="sidebar-item">
                    <a
                        class="sidebar-link waves-effect waves-dark sidebar-link"
                        href="{{ route('logout')}}"
                        onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();"
                    ><i class="fa fa-power-off me-1 ms-1"></i
                        ><span class="hide-menu">Logout</span></a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
