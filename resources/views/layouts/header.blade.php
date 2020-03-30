<header class="topbar">
    <nav class="navbar top-navbar navbar-expand-md navbar-light">
        <!-- ============================================================== -->
        <!-- Logo -->
        <!-- ============================================================== -->
        <div class="navbar-header">
            <a class="navbar-brand" href="#">
              <!-- Logo icon -->
              <b>
                  <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                  <!-- Dark Logo icon -->
                  <img width="50" height="50" src="{{asset('assets/images/logo-icon.png')}}" alt="homepage" class="dark-logo" />
                  <!-- Light Logo icon -->
                  <img width="50" height="50" src="{{asset('assets/images/logo-icon.png')}}" alt="homepage" class="light-logo" />
              </b>
              <!--End Logo icon -->
              <!-- Logo text -->
              <span class="logo-text text-dark" style="margin-left: 5px;">{{ config('app.name', 'Laravel') }}</span>
            </a>
        </div>
        <!-- ============================================================== -->
        <!-- End Logo -->
        <!-- ============================================================== -->
        <div class="navbar-collapse">
            <!-- ============================================================== -->
            <!-- toggle and nav items -->
            <!-- ============================================================== -->
            <ul class="navbar-nav mr-auto">
                <!-- This is  -->
                <li class="nav-item"> <a class="nav-link nav-toggler hidden-md-up waves-effect waves-dark" href="javascript:void(0)"><i class="ti-menu"></i></a> </li>
                <li class="nav-item"> <a class="nav-link sidebartoggler hidden-sm-down waves-effect waves-dark" href="javascript:void(0)"><i class="ti-menu"></i></a> </li>
            </ul>
            <!-- ============================================================== -->
            <!-- User profile and search -->
            <!-- ============================================================== -->
            <ul class="navbar-nav my-lg-0">
                <!-- ============================================================== -->
                <!-- Notif -->
                <!-- ============================================================== -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="mdi mdi-message"></i>
                      <div class="notify">
                        <span class="heartbit"></span><span class="point"></span>
                      </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right mailbox animated bounceInDown">
                        <ul>
                            <li>
                                <div class="drop-title">Notifications</div>
                            </li>
                            <li>
                                <div class="message-center message-center-notification">
                                    <!-- Message -->
                                </div>
                            </li>
                            <li>
                                <a class="nav-link text-center" href="{{ route('notification.index')}}"> <strong>Check all notifications</strong> <i class="fa fa-angle-right"></i> </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <!-- ============================================================== -->
                <!-- End Notif -->
                <!-- ============================================================== -->


                <!-- ============================================================== -->
                <!-- Profile -->
                <!-- ============================================================== -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="{{asset('assets/images/gear.png')}}" alt="user" class="profile-pic" /></a>
                    <div class="dropdown-menu dropdown-menu-right animated flipInY">
                        <ul class="dropdown-user">
                            <li><a href="{{ route('profile') }}"><i class="ti-user"></i> My Profile</a></li>
                            <li>
                              <a href="javascript:void(0);" onclick="document.getElementById('logoutUser').submit();"><i class="fa fa-power-off"></i> Logout</a>
                              <form id="logoutUser" action="{{ route('logout') }}" method="post">
                                @csrf
                              </form>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</header>
