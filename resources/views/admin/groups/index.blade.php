@extends('admin.layouts.master')
@section('content')
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<style>
    .color-sidebar {
        color: #757575;
    }

    .selected .color-sidebar {
        color: #ffffff;
    }
</style>
<div class="page-breadcrumb">
    <div class="row align-items-center">
        <div class="col-6">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 d-flex align-items-center">
                    <li class="breadcrumb-item"><a href="index.html" class="link"><i class="mdi mdi-home-outline fs-4"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Groups</li>
                    @if (Request::path() == 'admin/groups/send-group-message')
                        <li class="breadcrumb-item active" aria-current="page">Send New Group Message to Group</li>
                    @elseif (Request::path() == 'admin/groups')
                        <li class="breadcrumb-item active" aria-current="page">History Group Messages</li>
                    @elseif (Request::path() == 'admin/groups/get-list-group')
                        <li class="breadcrumb-item active" aria-current="page">Get List Groups</li>
                    @elseif (Request::path() == 'admin/messages/schedule-message' || Request::is('admin/messages/send-schedule-message'))
                        <li class="breadcrumb-item active" aria-current="page">Schedule Message</li>
                    @endif

                    @if (Request::is('admin/groups/schedule-group-message'))
                        <li class="breadcrumb-item active" aria-current="page">Send Schedule Group Message</li>
                    @endif
                </ol>
                </nav>
            {{-- <h1 class="mb-0 fw-bold">Dashboard</h1>  --}}
        </div>
    </div>
</div>
<!-- ============================================================== -->
<!-- End Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- Container fluid  -->
<!-- ============================================================== -->
<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Sales chart -->
    <!-- ============================================================== -->
    <div class="row">
        <div class="col-lg-3">
            <div class="card" style="height: auto">
                <div style="margin-top:10px; margin-left: 20px;">
                    <b>Groups</b>
                </div>
                <div class="scroll-sidebar">
                    <!-- Sidebar navigation-->
                    <nav class="sidebar-nav">
                        <ul id="sidebarnav">
                            <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                    href="{{ route('admin.send-group-message') }}" aria-expanded="false"><i class="mdi mdi-pencil-box-outline" style="color: #757575"></i><span
                                        class="color-sidebar">New Message to Group</span></a></li>
                            <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                    href="{{ route('admin.groups') }}" aria-expanded="false"><i class="mdi mdi-clock" style="color: #757575"></i><span
                                        class="color-sidebar">History Message</span></a></li>
                            <li class="sidebar-item {{ Request::is('admin/groups/send-schedule-message') ? 'selected' : '' }}"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                href="{{ route('admin.get-list-group') }}" aria-expanded="false"><i class="mdi mdi-clipboard-list-outline" style="color: #757575"></i><span
                                    class="color-sidebar">Get List Group</span></a></li>
                            <li class="sidebar-item {{ Request::is('admin/groups/send-schedule-group-message') || Request::is('admin/groups/edit-schedule-group-message/*') ? 'selected' : '' }}"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                href="{{ route('admin.schedule-group-message') }}" aria-expanded="false"><i class="mdi mdi-clock-edit-outline" style="color: #757575"></i><span
                                    class="color-sidebar">Schedule</span></a></li>
                            {{-- <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                href="{{ route('admin.campaign') }}" aria-expanded="false"><i class="mdi mdi-bullhorn-outline" style="color: #757575"></i><span
                                    class="color-sidebar">Campaign</span></a></li> --}}
                        </ul>
            
                    </nav>
                    <!-- End Sidebar navigation -->
                </div>
            </div>
        </div>
        <div class="col-lg-9">
            @yield('content-groups')
        </div>
    </div>
 
</div>
<!-- ============================================================== -->
<!-- End Container fluid  -->
<!-- ============================================================== -->
@endsection