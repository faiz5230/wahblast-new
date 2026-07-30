<aside class="left-sidebar" data-sidebarbg="skin6">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                        href="{{ route('admin.dashboard') }}" aria-expanded="false"><i class="mdi mdi-view-dashboard"></i><span
                            class="hide-menu">Dashboards</span></a></li>
                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                        href="{{ route('admin.device') }}" aria-expanded="false"><i
                            class="mdi mdi-devices"></i><span class="hide-menu">Devices</span></a></li>
                <li class="sidebar-item {{ Request::is('admin/messages*') ? 'selected' : '' }}"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                    href="{{ route('admin.messages') }}" aria-expanded="false"><i class="mdi mdi-message-text"></i><span
                        class="hide-menu">Messages</span></a></li>
                {{-- <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                        href="{{ route('admin.chats') }}" aria-expanded="false"><i class="mdi mdi-message-text"></i><span
                            class="hide-menu">Message History</span></a></li> --}}
                 <li class="sidebar-item {{ Request::is('admin/groups*') ? 'selected' : '' }}"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                        href="{{ route('admin.send-group-message') }}" aria-expanded="false"><i class="mdi mdi-forum"></i><span
                            class="hide-menu">Group Chats</span></a></li>
                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                        href="{{ route('admin.contacts') }}" aria-expanded="false"><i class="mdi mdi-contacts"></i><span
                            class="hide-menu">Contacts&nbsp;<!--<small>- Coming Soon</small>--></span></a></li>
                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                    href="{{ route('admin.bot-auto-reply') }}" aria-expanded="false"><i class="mdi mdi-robot-happy-outline"></i><span
                        class="hide-menu">Bot Auto Reply&nbsp;<!--<small>- Coming Soon</small>--></span></a></li>
                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                    href="{{ route('admin.number-checker') }}" aria-expanded="false"><i class="mdi mdi-phone"></i><span
                        class="hide-menu">WA Number Checker&nbsp;<!--<small>- Coming Soon</small>--></span></a></li>
                            <br>
                            <div><b>API&nbsp;</b></div>
                            <hr size="3">
                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                        href="{{ route('admin.documentation-api') }}" aria-expanded="false"><i class="mdi mdi-xml m-r-5 m-l-5"></i><span
                            class="hide-menu">API Documentation</span></a></li>
                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                        href="javascript:void()" aria-expanded="false"><i class="mdi mdi-arrow-left-drop-circle m-r-5 m-l-5"></i><span
                            class="hide-menu">Postman <div class="badge bg-secondary"> Soon</div></span></a></li>
                            <br>
                            <div><b>Others</b></div>
                            <hr size="3">
                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                        href="{{ route('users.index') }}" aria-expanded="false"><i class="mdi mdi-account-group-outline m-r-5 m-l-5"></i><span
                            class="hide-menu">Users</span></a></li>
                <li class="sidebar-item {{ Request::is('admin/system-setting') || Request::is('admin/app-setting') || Request::is('admin/template-message-setting') ? 'selected' : '' }}"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                    href="{{ route('admin.account-setting',Auth::id()) }}" aria-expanded="false"><i class="mdi mdi-settings m-r-5 m-l-5"></i><span
                        class="hide-menu">Settings</span></a></li>
                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                        href="{{ route('admin.logout') }}" aria-expanded="false"><i class="mdi mdi-logout m-r-5 m-l-5"></i><span
                            class="hide-menu">Logout</span></a></li>
            </ul>

        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>