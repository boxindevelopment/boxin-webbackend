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

                <li class="{{ Route::currentRouteNamed('warehouses.index')||Route::currentRouteNamed('warehouses.create')||Route::currentRouteNamed('warehouses-city.index')||Route::currentRouteNamed('warehouses-city.edit')||Route::currentRouteNamed('warehouses-area.index')||Route::currentRouteNamed('warehouses-area.edit') ? 'active' : null }}">
                  <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
                    <i class="mdi mdi-home-map-marker"></i>
                    <span class="hide-menu">Warehouse</span>
                  </a>
                  <ul aria-expanded="false" class="collapse">
                    @if(Auth::user()->roles_id == 3)
                    <li class="{{ Route::currentRouteNamed('warehouses-city.index')||Route::currentRouteNamed('warehouses-city.edit') ? 'active' : null }}">
                      <a href="{{ route('warehouses-city.index') }}"><i class="fa fa-circle"></i> &nbsp;Warehouse City</a>
                    </li>
                    @endif
                    <li class="{{ Route::currentRouteNamed('warehouses-area.index')||Route::currentRouteNamed('warehouses-area.edit') ? 'active' : null }}">
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

                <li class="{{ Route::currentRouteNamed('space.index')||Route::currentRouteNamed('space.create')||Route::currentRouteNamed('space.edit') ? 'active' : null }}">
                  <a class="waves-effect waves-dark" href="{{ route('space.index')}}" aria-expanded="false">
                    <i class="mdi mdi-grid"></i>
                    <span class="hide-menu">Spaces</span>
                  </a>
                </li>

                <li class="{{ Route::currentRouteNamed('box.index')||Route::currentRouteNamed('box.create')||Route::currentRouteNamed('box.edit') ? 'active' : null }}">
                  <a class="waves-effect waves-dark" href="{{ route('box.index')}}" aria-expanded="false">
                    <i class="mdi mdi-dropbox"></i>
                    <span class="hide-menu">Boxes</span>
                  </a>
                </li>

                <li class="{{ Route::currentRouteNamed('room.index')||Route::currentRouteNamed('room.create')||Route::currentRouteNamed('room.edit') ? 'active' : null }}">
                  <a class="waves-effect waves-dark" href="{{ route('room.index')}}" aria-expanded="false">
                    <i class="mdi mdi-home-outline"></i>
                    <span class="hide-menu">Rooms</span>
                  </a>
                </li>               

                <li class="{{ Route::currentRouteNamed('order.index')||Route::currentRouteNamed('order.create') ? 'active' : null }}">
                  <a class="waves-effect waves-dark" href="{{ route('order.index')}}" aria-expanded="false">
                    <i class="mdi mdi-cart-outline"></i>
                    <span class="hide-menu">Orders</span>
                  </a>
                </li>

                <li class="{{ Route::currentRouteNamed('pickup.index')||Route::currentRouteNamed('pickup.create') ? 'active' : null }}">
                  <a class="waves-effect waves-dark" href="{{ route('pickup.index')}}" aria-expanded="false">
                    <i class="mdi mdi-truck"></i>
                    <span class="hide-menu">Pickup Orders</span>
                  </a>
                </li>

                <li class="{{ Route::currentRouteNamed('storage.index') ? 'active' : null }}">
                  <a class="waves-effect waves-dark" href="{{ route('storage.index')}}" aria-expanded="false">
                    <i class="mdi mdi-checkbox-marked-outline"></i>
                    <span class="hide-menu">Storage</span>
                  </a>
                </li>

                <li class="{{ Route::currentRouteNamed('return.index')||Route::currentRouteNamed('return.create')||Route::currentRouteNamed('return.edit') ? 'active' : null }}">
                  <a class="waves-effect waves-dark" href="{{ route('return.index')}}" aria-expanded="false">
                    <i class="mdi mdi-keyboard-return"></i>
                    <span class="hide-menu">Return Boxes</span>
                  </a>
                </li>
                
                @if(Auth::user()->roles_id == 3)
                <li class="{{ Route::currentRouteNamed('user.index')||Route::currentRouteNamed('user.create') ? 'active' : null }}">
                  <a class="has-arrow waves-effect waves-dark" href="{{ route('user.index')}}" aria-expanded="false">
                    <i class="mdi mdi-account"></i>
                    <span class="hide-menu">Users</span>
                  </a>
                  <ul aria-expanded="false" class="collapse">
                    <li class="{{ Route::currentRouteNamed('user.index') ? 'active' : null }}">
                      <a href="{{ route('user.index') }}"><i class="fa fa-circle"></i> &nbsp;All Users</a>
                    </li>
                    <li class="{{ Route::currentRouteNamed('user.list_admincity') ? 'active' : null }}">
                      <a href="{{ route('user.list_admincity') }}"><i class="fa fa-circle"></i> &nbsp;Admin Area</a>
                    </li>
                    <li class="{{ Route::currentRouteNamed('user.list_admincity') ? 'active' : null }}">
                      <a href="{{ route('user.list_admincity') }}"><i class="fa fa-circle"></i> &nbsp;Admin Finance</a>
                    </li>
                    <li class="{{ Route::currentRouteNamed('user.list_superadmin') ? 'active' : null }}">
                      <a href="{{ route('user.list_superadmin') }}"><i class="fa fa-circle"></i> &nbsp;Super Admin</a>
                    </li>
                  </ul>
                </li>
                @endif
                
                <li class="{{ Route::currentRouteNamed('types-of-size.index')||Route::currentRouteNamed('types-of-size.edit') ? 'active' : null }}">
                  <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
                    <i class="mdi mdi-settings"></i>
                    <span class="hide-menu">Settings</span>
                  </a>
                  <ul aria-expanded="false" class="collapse">
                    @if(Auth::user()->roles_id == 3)
                    <li class="{{ Route::currentRouteNamed('types-of-size.index')||Route::currentRouteNamed('types-of-size.edit') ? 'active' : null }}">
                      <a href="{{ route('types-of-size.index') }}"><i class="fa fa-circle"></i> &nbsp;Types of Size</a>
                    </li>
                    @endif
                    <li class="{{ Route::currentRouteNamed('price.index')||Route::currentRouteNamed('price.edit') ? 'active' : null }}">
                      <a href="{{ route('price.index') }}"><i class="fa fa-circle"></i> &nbsp;Price</a>
                    </li>
                   <!--  <li class="{{ Route::currentRouteNamed('setting.create')||Route::currentRouteNamed('setting.index')||Route::currentRouteNamed('setting.edit') ? 'active' : null }}">
                      <a href="{{ route('setting.index') }}"><i class="fa fa-plus"></i> &nbsp;Others</a>
                    </li> -->
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
