<aside class="left-sidebar" data-sidebarbg="skin5">
    <?php
    $segment1 =  Request::segment(1);
    $segment2 =  Request::segment(2);
    $combine_segment=$segment1."/".$segment2;
    $isAdminEmployeeID=[
        1,2,2253,2267,2515,4277
    ];
  ?>
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav" class="pt-4">
                <li class="sidebar-item">
                    <a
                        class="sidebar-link waves-effect waves-dark sidebar-link"
                        href="{{ route('dashboard')}}"
                        aria-expanded="false"
                    ><i class="mdi mdi-view-dashboard"></i
                        ><span class="hide-menu">Dashboard</span></a>
                </li>

                <?php
                        $user_info =  App\Models\User::where(['id'=> Auth::user()->id])->first();
                        $id        = $user_info->role_id;

                        $menuAccessArray = [];
                        $get_role_info = App\Models\AclRoleInfo::where(['is_active'=> 1, 'id'=> $id])->first();
                        $menuAccess = (!empty($get_role_info->role_info)? json_decode($get_role_info->role_info):'');
                        if(!empty($menuAccess)){
                            foreach($menuAccess as $key=>$access){
                                if(gettype($access) == 'object') {
                                    foreach($access as $asses) {
                                        array_push($menuAccessArray, $asses);
                                    }
                                }
                                if(gettype($access) == 'integer') {
                                    array_push($menuAccessArray, $access);
                                }
                                array_push($menuAccessArray, $key);
                            }
                        }


                        $get_menu_info = App\Models\AclMenuInfo::where(['is_active'=> 1,'is_main_menu'=>1])->get();

                        if(!empty($get_menu_info)){
                            foreach($get_menu_info as $key=> $mainMenu){

                                $get_menu_info[$key]['mainChild']= App\Models\AclMenuInfo::where(['is_active'=> 1,'is_main_menu'=>2,'parent_id'=> $mainMenu->id])->get();
                            }
                        }
                    ?>

            @foreach($get_menu_info as $item)

                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow waves-effect waves-dark" href="{{$item->link}}" aria-expanded="false"
                        @if(in_array($item->id , $menuAccessArray))
                        style="display:show"
                        @else
                        style="display:none"
                        @endif
                        >
                        <i class="{{$item->glyphicon_icon}}"></i>
                        <span class="hide-menu"> {{$item->title}}  </span>
                    </a>

                    <ul aria-expanded="false" class="collapse first-level">
                        @if(!empty($item->mainChild))
                            @foreach($item->mainChild as $childKey => $row)
                                <li class="sidebar-item"  @if(in_array($row->id , $menuAccessArray))
                                    style="display:show"
                                    @else
                                    style="display:none"
                                  @endif
                         <?php if(in_array($segment1,[$row->link])){ echo 'class="active"';} ?>>
                                    <a href="{{ route($row->link)}}" class="sidebar-link">
                                        <i class="mdi mdi-note-outline"></i>
                                        <span class="hide-menu"> {{$row->title}} </span>
                                    </a>
                                </li>
                            @endforeach
                      @endif
                    </ul>
                </li>

            @endforeach
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
