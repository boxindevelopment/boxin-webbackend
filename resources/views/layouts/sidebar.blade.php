<!-- ============================================================== -->
<!-- Left Sidebar - style you can find in sidebar.scss  -->
<!-- ============================================================== -->
<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                {{-- <li class="user-profile">
                    <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
                      <span class="hide-menu">{{ Auth::user()->role }}</span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        <li>
                          <a href="javascript:void(0);" onclick="document.getElementById('logout-id').submit();">Logout</a>
                          <form id="logout-id" action="{{ route('logout') }}" method="post">
                            @csrf
                          </form>
                        </li>
                    </ul>
                </li> --}}

                <li class="nav-small-cap">MAIN MENU</li>
                <li class="nav-devider"></li>
                <li class="{{ Route::currentRouteNamed('dashboard') ? 'active' : null }}">
                    <a class="waves-effect waves-dark" href="{{ route('dashboard') }}" aria-expanded="false">
                      <i class="mdi mdi-gauge"></i>
                      <span class="hide-menu">Dashboard</span>
                    </a>
                </li>

                <li class="{{ Route::currentRouteNamed('warehouses.index')||Route::currentRouteNamed('warehouses.create')||Route::currentRouteNamed('warehouses-city.index')||Route::currentRouteNamed('warehouses-area.index') ? 'active' : null }}">
                  <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
                    <i class="mdi mdi-home-map-marker"></i>
                    <span class="hide-menu">Warehouse</span>
                  </a>
                  <ul aria-expanded="false" class="collapse">
                    <li class="{{ Route::currentRouteNamed('warehouses-city.index') ? 'active' : null }}">
                      <a href="{{ route('warehouses-city.index') }}"><i class="fa fa-circle"></i> &nbsp;Warehouse City</a>
                    </li>
                    <li class="{{ Route::currentRouteNamed('warehouses-area.index') ? 'active' : null }}">
                      <a href="{{ route('warehouses-area.index') }}"><i class="fa fa-circle"></i> &nbsp;Warehouse Areas</a>
                    </li>

                    <li class="{{ Route::currentRouteNamed('warehouses.create') ? 'active' : null }}">
                      <a href="{{ route('warehouses.create') }}"><i class="fa fa-plus"></i> &nbsp;Add Warehouse</a>
                    </li>

                    <li class="{{ Route::currentRouteNamed('warehouses.index') ? 'active' : null }}">
                      <a href="{{ route('warehouses.index')}}"><i class="fa fa-list"></i> &nbsp;List Warehouse</a>
                    </li>
                  </ul>
                </li>

                <li class="{{ Route::currentRouteNamed('space.index')||Route::currentRouteNamed('space.create') ? 'active' : null }}">
                  <a class="waves-effect waves-dark" href="{{ route('space.index')}}" aria-expanded="false">
                    <i class="mdi mdi-grid"></i>
                    <span class="hide-menu">Spaces</span>
                  </a>
                </li>

                <li class="{{ Route::currentRouteNamed('room.index')||Route::currentRouteNamed('room.create') ? 'active' : null }}">
                  <a class="waves-effect waves-dark" href="{{ route('room.index')}}" aria-expanded="false">
                    <i class="mdi mdi-home-outline"></i>
                    <span class="hide-menu">Rooms</span>
                  </a>
                </li>

                <li class="{{ Route::currentRouteNamed('box.index')||Route::currentRouteNamed('box.create') ? 'active' : null }}">
                  <a class="waves-effect waves-dark" href="{{ route('box.index')}}" aria-expanded="false">
                    <i class="mdi mdi-dropbox"></i>
                    <span class="hide-menu">Boxes</span>
                  </a>
                </li>

                <li class="{{ Route::currentRouteNamed('user.index')||Route::currentRouteNamed('user.create') ? 'active' : null }}">
                  <a class="waves-effect waves-dark" href="{{ route('user.index')}}" aria-expanded="false">
                    <i class="mdi mdi-account"></i>
                    <span class="hide-menu">Users</span>
                  </a>
                </li>

                @if(auth()->user()->can('member_new') || auth()->user()->can('member_list'))
                  <li class="{{ Route::currentRouteNamed('member.index')||Route::currentRouteNamed('member.edit')||Route::currentRouteNamed('member.create') ? 'active' : null }}">
                    <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
                      <i class="mdi mdi-account-multiple"></i>
                      <span class="hide-menu">Member</span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                      @can ('member_new')
                        <li class="{{ Route::currentRouteNamed('member.create') ? 'active' : null }}">
                          <a href="{{ route('member.create') }}">
                            <i class="fa fa-plus-square"></i> &nbsp;Create New
                          </a>
                        </li>
                      @endcan
                      @can ('member_list')
                        <li class="{{ Route::currentRouteNamed('member.index') ? 'active' : null }}">
                          <a href="{{ route('member.index') }}">
                            <i class="fa fa-list"></i> &nbsp;All List
                          </a>
                        </li>
                      @endcan
                    </ul>
                  </li>
                @endif

                @can ('admin_panel')
                  <li class="{{ Route::currentRouteNamed('new-user.index')||Route::currentRouteNamed('new-user.newrole')||Route::currentRouteNamed('new-user.listrole') ? 'active' : null }}">
                    <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
                      <i class="mdi mdi-lock"></i>
                      <span class="hide-menu">Admin Panel</span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                      <li class="{{ Route::currentRouteNamed('new-user.listrole') ? 'active' : null }}">
                        <a href="{{ route('new-user.listrole')}}"><i class="fa fa-list"></i> &nbsp;List Role</a>
                      </li>
                      <li class="{{ Route::currentRouteNamed('new-user.index') ? 'active' : null }}">
                        <a href="{{ route('new-user.index') }}"><i class="fa fa-list"></i> &nbsp;List User</a>
                      </li>

                    </ul>
                  </li>
                @endcan

                  </ul>
                </li>

            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
<!-- ============================================================== -->
<!-- End Left Sidebar - style you can find in sidebar.scss  -->
<!-- ============================================================== -->
