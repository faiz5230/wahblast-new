<header class="topbar" data-navbarbg="skin6">
    <nav class="navbar top-navbar navbar-expand-md navbar-light">
        <div class="navbar-header" data-logobg="skin6">
            <!-- ============================================================== -->
            <!-- Logo -->
            <!-- ============================================================== -->
            <a class="navbar-brand" href="index.html">
                <!-- Logo icon -->
                <b class="logo-icon">
                    <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                    <!-- Dark Logo icon -->
                    <img src="{{ App\Models\AppSetting::getValue('app_logo') ? asset('app_setting/' . App\Models\AppSetting::getValue('app_logo')) : asset('assets/images/wah-logo.png')}}" alt="homepage" class="dark-logo" style="max-width: 31px;"/>
                    <!-- Light Logo icon -->
                    <img src="{{ App\Models\AppSetting::getValue('app_logo') ? asset('app_setting/' . App\Models\AppSetting::getValue('app_logo')) : asset('assets/images/wah-logo.png')}}" alt="homepage" class="light-logo" style="max-width: 31px;"/>
                </b>
                <!--End Logo icon -->
                <!-- Logo text -->
                <span class="logo-text">
                    <!-- dark Logo text -->
                    <img src="{{ App\Models\AppSetting::getValue('app_logo_full') ? asset('app_setting/' . App\Models\AppSetting::getValue('app_logo_full')) : asset('assets/images/wahblast-logo-text.png')}} " alt="homepage" class="dark-logo" style="max-width: 160px;"/>
                    <!-- Light Logo text -->
                    {{-- <img src="{{ asset('assets/images/logo-light-text.png') }}" class="light-logo" alt="homepage" /> --}}
                </span>
            </a>
            <!-- ============================================================== -->
            <!-- End Logo -->
            <!-- ============================================================== -->
            <!-- This is for the sidebar toggle which is visible on mobile only -->
            <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i
                    class="mdi mdi-menu"></i></a>
        </div>
        <!-- ============================================================== -->
        <!-- End Logo -->
        <!-- ============================================================== -->
        <div class="navbar-collapse collapse" id="navbarSupportedContent" data-navbarbg="skin5">
            <!-- ============================================================== -->
            <!-- toggle and nav items -->
            <!-- ============================================================== -->
            <ul class="navbar-nav float-start me-auto">
                <!-- ============================================================== -->
                <!-- Search -->
                <!-- ============================================================== -->
                <li class="nav-item search-box"> <a class="nav-link waves-effect waves-dark"
                        href="javascript:void(0)"><i class="mdi mdi-magnify me-1"></i> <span class="font-16">Search</span></a>
                    <form class="app-search position-absolute">
                        <input type="text" class="form-control" placeholder="Search &amp; enter"> <a
                            class="srh-btn"><i class="mdi mdi-window-close"></i></a>
                    </form>
                </li>
            </ul>
            <!-- ============================================================== -->
            <!-- Right side toggle and nav items -->
            <!-- ============================================================== -->
            <ul class="navbar-nav float-end">
                <!-- ============================================================== -->
                <!-- User profile and search -->
                <!-- ============================================================== -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark pro-pic" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="https://bootdey.com/img/Content/avatar/avatar1.png" alt="user" class="rounded-circle" width="31">
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end user-dd animated" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('admin.profile',Auth::id())  }}"><i class="ti-user m-r-5 m-l-5"></i>
                            My Profile</a>
                        <a class="dropdown-item" href="{{ route('admin.account-setting',Auth::id()) }}"><i class="ti-settings m-r-5 m-l-5"></i>
                            Account Setting</a>
                        <a class="dropdown-item" href="{{ route('admin.logout') }}"><i class="mdi mdi-logout m-r-5 m-l-5"></i>
                            Logout</a>
                    </ul>
                </li>
                <!-- ============================================================== -->
                <!-- User profile and search -->
                <!-- ============================================================== -->
            </ul>
        </div>
    </nav>
</header>