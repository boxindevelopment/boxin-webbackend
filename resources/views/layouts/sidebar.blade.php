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

                @if(Auth::user()->roles_id == 3)
                <li class="{{ Route::currentRouteNamed('city.index')||Route::currentRouteNamed('city.create')||Route::currentRouteNamed('city.edit') ? 'active' : null }}">
                  <a class="waves-effect waves-dark" href="{{ route('city.index')}}" aria-expanded="false">
                    <i class="mdi mdi-checkbox-blank-circle"></i>
                    <span class="hide-menu">Cities</span>
                  </a>
                </li>

                <li class="{{ Route::currentRouteNamed('area.index')||Route::currentRouteNamed('area.create')||Route::currentRouteNamed('area.edit') ? 'active' : null }}">
                  <a class="waves-effect waves-dark" href="{{ route('area.index')}}" aria-expanded="false">
                    <i class="mdi mdi-home-map-marker"></i>
                    <span class="hide-menu">Areas</span>
                  </a>
                </li>
                @endif

                <li class="{{ Route::currentRouteNamed('space.index')||Route::currentRouteNamed('space.create')||Route::currentRouteNamed('space.edit') ? 'active' : null }}">
                  <a class="waves-effect waves-dark" href="{{ route('space.index')}}" aria-expanded="false">
                    <i class="mdi mdi-home-outline"></i>
                    <span class="hide-menu">Spaces</span>
                  </a>
                </li>

                <li class="{{ Route::currentRouteNamed('shelves.index')||Route::currentRouteNamed('shelves.create')||Route::currentRouteNamed('shelves.edit') ? 'active' : null }}">
                  <a class="waves-effect waves-dark" href="{{ route('shelves.index')}}" aria-expanded="false">
                    <i class="mdi mdi-grid"></i>
                    <span class="hide-menu">Shelves</span>
                  </a>
                </li>

                <li class="{{ Route::currentRouteNamed('box.index')||Route::currentRouteNamed('box.create')||Route::currentRouteNamed('box.edit') ? 'active' : null }}">
                  <a class="waves-effect waves-dark" href="{{ route('box.index')}}" aria-expanded="false">
                    <i class="mdi mdi-dropbox"></i>
                    <span class="hide-menu">Boxes</span>
                  </a>
                </li>      

                <li class="{{ Route::currentRouteNamed('category.index')||Route::currentRouteNamed('category.create')||Route::currentRouteNamed('category.edit') ? 'active' : null }}">
                  <a class="waves-effect waves-dark" href="{{ route('category.index')}}" aria-expanded="false">
                    <i class="mdi mdi-format-list-bulleted"></i>
                    <span class="hide-menu">Categories</span>
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

                <li class="{{ Route::currentRouteNamed('order.index')||Route::currentRouteNamed('order.create') ? 'active' : null }}">
                  <a class="waves-effect waves-dark" href="{{ route('order.index')}}" aria-expanded="false">
                    <i class="mdi mdi-cart-outline"></i>
                    <span class="hide-menu">Payments</span>
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
                <li class="{{ Route::currentRouteNamed('user.index')||Route::currentRouteNamed('user.create')||Route::currentRouteNamed('user.admin.index')||Route::currentRouteNamed('user.admin.edit')||Route::currentRouteNamed('user.admin.update')||Route::currentRouteNamed('user.finance.index')||Route::currentRouteNamed('user.finance.edit') ? 'active' : null }}">
                  <a class="has-arrow waves-effect waves-dark" href="{{ route('user.index')}}" aria-expanded="false">
                    <i class="mdi mdi-account"></i>
                    <span class="hide-menu">Users</span>
                  </a>
                  <ul aria-expanded="false" class="collapse">
                    <li class="{{ Route::currentRouteNamed('user.all.index') ? 'active' : null }}">
                      <a href="{{ route('user.index') }}"><i class="fa fa-circle"></i> &nbsp;All Users</a>
                    </li>
                    <li class="{{ Route::currentRouteNamed('user.admin.index')||Route::currentRouteNamed('user.admin.edit') ? 'active' : null }}">
                      <a href="{{ route('user.admin.index') }}"><i class="fa fa-circle"></i> &nbsp;Admin Area</a>
                    </li>
                    <li class="{{ Route::currentRouteNamed('user.finance.index')||Route::currentRouteNamed('user.finance.edit') ? 'active' : null }}">
                      <a href="{{ route('user.finance.index') }}"><i class="fa fa-circle"></i> &nbsp;Admin Finance</a>
                    </li>
                    <li class="{{ Route::currentRouteNamed('user.superadmin.index') ? 'active' : null }}">
                      <a href="{{ route('user.superadmin.index') }}"><i class="fa fa-circle"></i> &nbsp;Super Admin</a>
                    </li>
                  </ul>
                </li>
                @endif
                
                <li class="{{ Route::currentRouteNamed('types-of-size.index')||Route::currentRouteNamed('types-of-size.create')||Route::currentRouteNamed('types-of-size.edit') ? 'active' : null }}">
                  <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
                    <i class="mdi mdi-settings"></i>
                    <span class="hide-menu">Settings</span>
                  </a>
                  <ul aria-expanded="false" class="collapse">
                    @if(Auth::user()->roles_id == 3)
                    <li class="{{ Route::currentRouteNamed('types-of-size.index')||Route::currentRouteNamed('types-of-size.create')||Route::currentRouteNamed('types-of-size.edit') ? 'active' : null }}">
                      <a href="{{ route('types-of-size.index') }}"><i class="fa fa-circle"></i> &nbsp;Size</a>
                    </li>
                    @endif
                    <li class="{{ Route::currentRouteNamed('price.index')||Route::currentRouteNamed('price.edit') ? 'active' : null }}">
                      <a href="{{ route('price.index') }}"><i class="fa fa-circle"></i> &nbsp;Price</a>
                    </li>
                    <li class="{{ Route::currentRouteNamed('delivery-fee.create')||Route::currentRouteNamed('delivery-fee.index')||Route::currentRouteNamed('delivery-fee.edit') ? 'active' : null }}">
                      <a href="{{ route('delivery-fee.index') }}"><i class="fa fa-circle"></i> &nbsp;Delivery Fee</a>
                    </li> 
                    @if(Auth::user()->roles_id == 3)
                    <li class="{{ Route::currentRouteNamed('settings.index')||Route::currentRouteNamed('settings.edit') ? 'active' : null }}">
                      <a href="{{ route('settings.index') }}"><i class="fa fa-plus"></i> &nbsp;Others</a>
                    </li>
                    @endif
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
